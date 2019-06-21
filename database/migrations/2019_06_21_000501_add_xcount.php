<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddXcount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->integer('xcount')->nullable();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('xcount_for_tb')->default(false);
        });

        DB::statement("
        create or replace view v_individual_tie_breaker_1 as
        select
        tb.tie_breaker_name ,
        tb.category_id , 
        tb.category_name ,
        tb.participant_id , 
        tb.participant_name ,
        sum(COALESCE(tb.score, 0)) as score
    from (
        select
            e.name as tie_breaker_name ,
            cat.id as category_id ,
            cat.name as category_name ,
            c.id as participant_id ,
            c.name as participant_name ,
            SUM(COALESCE(s.xcount, 0)) as score
        from events e
        join participants c
        left join categories cat on c.category_id = cat.id
        left join scores s on c.id = s.participant_id and e.id = s.event_id
        where e.deleted_at is null
        and cat.deleted_at is null
        and s.deleted_at is null
        and (select xcount_for_tb from settings order by id limit 1) <> 0
        group by e.name, cat.id, cat.name, c.id, c.name         
        UNION
        select
            e.name as tie_breaker_name ,
            cat.id as category_id ,
            cat.name as category_name ,
            c.id as participant_id ,
            c.name as participant_name ,
            SUM(COALESCE(s.score, 0)) as score
        from events e
        join participants c
        left join categories cat on c.category_id = cat.id
        left join scores s on c.id = s.participant_id and e.id = s.event_id
        where e.deleted_at is null
        and cat.deleted_at is null
        and s.deleted_at is null
        and e.id in (select id from events where use_in_tb_1 = 1)
        group by e.name, cat.id, cat.name, c.id, c.name         
    ) tb
    group by
        tb.tie_breaker_name ,
        tb.category_id , 
        tb.category_name ,
        tb.participant_id , 
        tb.participant_name
        ");

        DB::statement("
        create or replace view v_individual_ranking as
        select
            cat.id as category_id ,
            cat.name as category_name ,
            e.id as event_id ,
            e.name as event_name ,
            cmp.id as team_id ,
            cmp.name as team_name ,
            c.id as participant_id ,
            c.name as participant_name ,
            s.id as score_id ,
            COALESCE(s.score, 0) as score ,
            COALESCE(tb1.score, 0) as tie_breaker_1 ,
            COALESCE(tb2.score, 0) as tie_breaker_2 ,
            COALESCE(tb3.score, 0) as tie_breaker_3 ,
            COALESCE(tb4.score, 0) as tie_breaker_4 , 
            cmp.exclude_team_rank ,
            cmp.exclude_ind_rank
        from categories cat
        join events e
        inner join participants c on cat.id = c.category_id
        left join teams cmp on c.team_id = cmp.id
        left join scores s on e.id = s.event_id and c.id = s.participant_id
        left join v_individual_tie_breaker_1 tb1 on s.participant_id = tb1.participant_id and e.name = tb1.tie_breaker_name
        left join v_individual_tie_breaker_2 tb2 on s.participant_id = tb2.participant_id and e.name = tb2.tie_breaker_name
        left join v_individual_tie_breaker_3 tb3 on s.participant_id = tb3.participant_id and e.name = tb3.tie_breaker_name
        left join v_individual_tie_breaker_4 tb4 on s.participant_id = tb4.participant_id and e.name = tb4.tie_breaker_name
        where cat.deleted_at is null
        and cmp.exclude_ind_rank = 0
        and e.deleted_at is null 
        /*and cmp.deleted_at is null*/
        /*and c.deleted_at is null*/
        and s.deleted_at is null
        order by cat.id, e.id, s.score desc, tb1.score desc, tb2.score desc, tb3.score desc, tb4.score desc       
        ");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->dropColumn('xcount');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('xcount_for_tb');
        });

        (new CreateSummaryViews())->up();
    }
}
