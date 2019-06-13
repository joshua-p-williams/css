<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummaryViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        create or replace view v_individual_tie_breaker_1 as
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
        ");

        DB::statement("
        create or replace view v_individual_tie_breaker_2 as
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
        and e.id in (select id from events where use_in_tb_2 = 1)
        group by e.name, cat.id, cat.name, c.id, c.name        
        ");

        DB::statement("
        create or replace view v_individual_tie_breaker_3 as
        select
            'Combined Responsibility Events' as tie_breaker_name ,
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
        and e.id in (select id from events where use_in_tb_3 = 1)
        group by cat.id, cat.name, c.id, c.name        
        ");

        DB::statement("
        create or replace view v_individual_tie_breaker_4 as
        select
            'Combined Shooting Events' as tie_breaker_name ,
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
        and e.id in (select id from events where use_in_tb_4 = 1)
        group by cat.id, cat.name, c.id, c.name      
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
        create or replace view v_overall_ranking as
        select
            s.category_id ,
            s.category_name ,
            cmp.id as team_id ,
            cmp.name as team_name ,
            s.participant_id ,
            s.participant_name ,
            sum(s.score) as score ,
            sum(s.tie_breaker_1) as tie_breaker_1 ,
            sum(s.tie_breaker_2) as tie_breaker_2 ,
            sum(s.tie_breaker_3) as tie_breaker_3 ,
            sum(s.tie_breaker_4) as tie_breaker_4
        from v_individual_ranking s
        inner join participants c on s.participant_id = c.id
        left join teams cmp on c.team_id = cmp.id
        group by
            s.category_id ,
            s.category_name ,
            cmp.id,
            cmp.name,
            s.participant_id ,
            s.participant_name
        order by
            sum(s.tie_breaker_1) desc,
            sum(s.tie_breaker_2) desc,
            sum(s.tie_breaker_3) desc,
            sum(s.tie_breaker_4) desc
        ");

        DB::statement("
        create or replace view v_tc_submitted_scores as
        select
            s.team_id ,
            cmp.name as team_name ,
            s.event_id ,
            e.name as event_name ,
            count(*) as submitted_score_count
        from scores s
        inner join events e on s.event_id = e.id
        inner join teams cmp on s.team_id = cmp.id
        where s.deleted_at is null
        and e.deleted_at is null
        group by s.event_id, cmp.name, s.event_id, e.name, s.team_id
        ");

        DB::statement("
        create or replace view v_tc_team_participants as
        select
            c.team_id ,
            cmp.name as team_name ,
            count(*) as participant_count
        from participants c
        inner join teams cmp on c.team_id = cmp.id
        /*where c.deleted_at is null and cmp.deleted_at is null*/
        group by c.team_id, cmp.name
        ");

        DB::statement("
        create or replace view v_tc_event_team_completion as
        select
            e.id as event_id ,
            e.name as event_name ,
            team_participants.team_id ,
            team_participants.team_name ,
            team_participants.participant_count ,
            COALESCE(submitted_scores.submitted_score_count, 0) as submitted_score_count ,
            (COALESCE(submitted_scores.submitted_score_count, 0) / team_participants.participant_count) * 100 as percent_complete
        from events e
        join v_tc_team_participants team_participants
        left join v_tc_submitted_scores submitted_scores on e.id = submitted_scores.event_id and team_participants.team_id = submitted_scores.team_id
        ");

        DB::statement("
        create or replace view v_team_completion as
        select
            e.id as event_id ,
            e.name as event_name ,
            cat.id as category_id ,
            cat.name as category_name , 
            cc.id as team_id ,
            cc.name as team_name ,
            COALESCE(event_team_completion.participant_count, 0) as participant_count ,
            COALESCE(event_team_completion.submitted_score_count, 0) as submitted_score_count,
            case
                when COALESCE(event_team_completion.participant_count, 0) <= 0 then 100.00
                else COALESCE(event_team_completion.percent_complete, 0)
            end percent_complete
        from teams cc
        join events e
        left join categories cat on cc.category_id = cat.id
        left join v_tc_event_team_completion event_team_completion on e.id = event_team_completion.event_id and cc.id = event_team_completion.team_id
        where e.deleted_at is null
        and cat.deleted_at is null
        /*and cc.deleted_at is null*/
        order by cc.name, e.name
        ");

        DB::statement("
        create or replace view v_cc_submitted_scores as
        select
            s.event_id ,
            e.name as event_name ,
            c.category_id ,
            cat.name as category_name ,
            count(*) as submitted_score_count
        from scores s
        inner join events e on s.event_id = e.id
        inner join participants c on s.participant_id = c.id
        inner join categories cat on c.category_id = cat.id
        where s.deleted_at is null
        and e.deleted_at is null
        /*and c.deleted_at is null*/
        and cat.deleted_at is null
        group by s.event_id, e.name, c.category_id, cat.name  
        ");

        DB::statement("
        create or replace view v_cc_category_paricipants as
        select
            c.category_id ,
            cat.name as category_name,
            count(*) as participant_count
        from participants c
        inner join categories cat on c.category_id = cat.id
        where cat.deleted_at is null
        /*and c.deleted_at is null*/
        group by c.category_id, cat.name
        ");

        DB::statement("
        create or replace view v_cc_event_category_completion as
        select
            e.id as event_id ,
            e.name as event_name ,
            category_paricipants.category_id ,
            category_paricipants.category_name ,
            category_paricipants.participant_count ,
            COALESCE(submitted_scores.submitted_score_count, 0) as submitted_score_count ,
            (COALESCE(submitted_scores.submitted_score_count, 0) / category_paricipants.participant_count) * 100 as percent_complete
        from events e
        join v_cc_category_paricipants category_paricipants
        left join v_cc_submitted_scores submitted_scores on e.id = submitted_scores.event_id and category_paricipants.category_id = submitted_scores.category_id
        ");

        DB::statement("
        create or replace view v_category_completion as
        select
            e.id as event_id ,
            e.name as event_name ,
            cat.id as category_id ,
            cat.name as category_name ,
            COALESCE(event_category_completion.participant_count, 0) as participant_count ,
            COALESCE(event_category_completion.submitted_score_count, 0) as submitted_score_count,
            case
                when COALESCE(event_category_completion.participant_count, 0) <= 0 then 100.00
                else COALESCE(event_category_completion.percent_complete, 0)
            end percent_complete
        from categories cat
        join events e
        left join v_cc_event_category_completion event_category_completion on e.id = event_category_completion.event_id and cat.id = event_category_completion.category_id
        where cat.deleted_at is null
        and e.deleted_at is null
        order by cat.name, e.name
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
        DB::statement("DROP VIEW v_overall_team_ranking");
        DB::statement("DROP VIEW v_category_completion");
        DB::statement("DROP VIEW v_cc_event_category_completion");
        DB::statement("DROP VIEW v_cc_category_paricipants");
        DB::statement("DROP VIEW v_cc_submitted_scores");
        DB::statement("DROP VIEW v_team_completion");
        DB::statement("DROP VIEW v_tc_event_team_completion");
        DB::statement("DROP VIEW v_tc_team_participants");
        DB::statement("DROP VIEW v_tc_submitted_scores");
        DB::statement("DROP VIEW v_overall_ranking");
        DB::statement("DROP VIEW v_team_ranking");
        DB::statement("DROP VIEW v_individual_ranking");
        DB::statement("DROP VIEW v_individual_tie_breaker_1");
        DB::statement("DROP VIEW v_individual_tie_breaker_2");
        DB::statement("DROP VIEW v_individual_tie_breaker_3");
        DB::statement("DROP VIEW v_individual_tie_breaker_4");
    }
}
