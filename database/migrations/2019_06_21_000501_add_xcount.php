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
