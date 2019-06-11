<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateViewsForRankingExclusions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
        left join v_individual_tie_breaker_1 tb1 on s.participant_id = tb1.participant_id
        left join v_individual_tie_breaker_2 tb2 on s.participant_id = tb2.participant_id
        left join v_individual_tie_breaker_3 tb3 on s.participant_id = tb3.participant_id
        left join v_individual_tie_breaker_4 tb4 on s.participant_id = tb4.participant_id
        where cat.deleted_at is null
        and cmp.exclude_ind_rank = 0
        and e.deleted_at is null 
        /*and cmp.deleted_at is null*/
        /*and c.deleted_at is null*/
        and s.deleted_at is null
        order by cat.id, e.id, s.score desc, tb1.score desc, tb2.score desc, tb3.score desc, tb4.score desc
        ");


        DB::statement("
        create or replace view v_team_ranking as
        select
            s.category_id ,
            s.category_name ,
            s.event_id ,
            s.event_name ,
            s.team_id ,
            s.team_name ,
            sum(s.score) as score ,
            sum(s.tie_breaker_1) as tie_breaker_1,
            sum(s.tie_breaker_2) as tie_breaker_2,
            sum(s.tie_breaker_3) as tie_breaker_3,
            sum(s.tie_breaker_4) as tie_breaker_4
        from v_individual_ranking s
        where s.exclude_team_rank = 0
        group by
            s.category_id ,
            s.category_name ,
            s.event_id ,
            s.event_name ,
            s.team_id ,
            s.team_name
        order by
            s.category_name,
            s.event_name,
            sum(s.score) desc,
            sum(s.tie_breaker_1) desc,
            sum(s.tie_breaker_2) desc,
            sum(s.tie_breaker_3) desc,
            sum(s.tie_breaker_4) desc
        ");

        DB::statement("
		create or replace view v_overall_team_ranking as
        select
            s.category_id ,
            s.category_name ,
            s.team_id ,
            s.team_name ,
            sum(s.score) as score ,
            sum(s.tie_breaker_1) as tie_breaker_1 ,
            sum(s.tie_breaker_2) as tie_breaker_2 ,
            sum(s.tie_breaker_3) as tie_breaker_3 ,
            sum(s.tie_breaker_4) as tie_breaker_4
        from v_team_ranking s
        group by
            s.category_id ,
            s.category_name ,
            s.team_id ,
            s.team_name
        order by
            sum(s.tie_breaker_1) desc,
            sum(s.tie_breaker_2) desc,
            sum(s.tie_breaker_3) desc,
            sum(s.tie_breaker_4) desc
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //DB::statement("DROP VIEW v_individual_ranking");
    }
}
