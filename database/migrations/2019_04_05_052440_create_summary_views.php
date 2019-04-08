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
            c.id as contact_id ,
            c.name as contact_name ,
            SUM(COALESCE(s.score, 0)) as score
        from events e
        join contacts c
        left join categories cat on c.category_id = cat.id
        left join scores s on c.id = s.contact_id and e.id = s.event_id
        where e.deleted_at is null
        and cat.deleted_at is null
        and e.name = 'Responsibility Exam'
        group by e.name, cat.id, cat.name, c.id, c.name         
        ");

        DB::statement("
        create or replace view v_individual_tie_breaker_2 as
        select
            e.name as tie_breaker_name ,
            cat.id as category_id ,
            cat.name as category_name ,
            c.id as contact_id ,
            c.name as contact_name ,
            SUM(COALESCE(s.score, 0)) as score
        from events e
        join contacts c
        left join categories cat on c.category_id = cat.id
        left join scores s on c.id = s.contact_id and e.id = s.event_id
        where e.deleted_at is null
        and cat.deleted_at is null
        and e.name = 'Safety Trail'
        group by e.name, cat.id, cat.name, c.id, c.name        
        ");

        DB::statement("
        create or replace view v_individual_tie_breaker_3 as
        select
            'Combined Responsibility Events' as tie_breaker_name ,
            cat.id as category_id ,
            cat.name as category_name ,
            c.id as contact_id ,
            c.name as contact_name ,
            SUM(COALESCE(s.score, 0)) as score
        from events e
        join contacts c
        left join categories cat on c.category_id = cat.id
        left join scores s on c.id = s.contact_id and e.id = s.event_id
        where e.deleted_at is null
        and cat.deleted_at is null
        and e.name in ('Responsibility Exam', 'Orienteering', 'Wildlife Identification', 'Safety Trail')
        group by cat.id, cat.name, c.id, c.name        
        ");

        DB::statement("
        create or replace view v_individual_tie_breaker_4 as
        select
            'Combined Shooting Events' as tie_breaker_name ,
            cat.id as category_id ,
            cat.name as category_name ,
            c.id as contact_id ,
            c.name as contact_name ,
            SUM(COALESCE(s.score, 0)) as score
        from events e
        join contacts c
        left join categories cat on c.category_id = cat.id
        left join scores s on c.id = s.contact_id and e.id = s.event_id
        where e.deleted_at is null
        and cat.deleted_at is null
        and e.name in ('Shotgun', 'Rifle', 'Archery', 'Muzzleloader')
        group by cat.id, cat.name, c.id, c.name      
        ");

        DB::statement("
        create or replace view v_individual_ranking as
        select
            cat.id as category_id ,
            cat.name as category_name ,
            e.id as event_id ,
            e.name as event_name ,
            cmp.id as company_id ,
            cmp.name as company_name ,
            c.id as contact_id ,
            c.name as contact_name ,
            s.id as score_id ,
            COALESCE(s.score, 0) as score ,
            COALESCE(tb1.score, 0) as tie_breaker_1 ,
            COALESCE(tb2.score, 0) as tie_breaker_2 ,
            COALESCE(tb3.score, 0) as tie_breaker_3 ,
            COALESCE(tb4.score, 0) as tie_breaker_4 
        from categories cat
        join events e
        inner join contacts c on cat.id = c.category_id
        left join contact_companies cmp on c.company_id = cmp.id
        left join scores s on e.id = s.event_id and c.id = s.contact_id
        left join v_individual_tie_breaker_1 tb1 on s.contact_id = tb1.contact_id
        left join v_individual_tie_breaker_2 tb2 on s.contact_id = tb2.contact_id
        left join v_individual_tie_breaker_3 tb3 on s.contact_id = tb3.contact_id
        left join v_individual_tie_breaker_4 tb4 on s.contact_id = tb4.contact_id
        where cat.deleted_at is null
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
            s.company_id ,
            s.company_name ,
            sum(s.score) as score ,
            sum(s.tie_breaker_1) as tie_breaker_1,
            sum(s.tie_breaker_2) as tie_breaker_2,
            sum(s.tie_breaker_3) as tie_breaker_3,
            sum(s.tie_breaker_4) as tie_breaker_4
        from v_individual_ranking s
        group by
            s.category_id ,
            s.category_name ,
            s.event_id ,
            s.event_name ,
            s.company_id ,
            s.company_name
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
            cmp.id as company_id ,
            cmp.name as company_name ,
            s.contact_id ,
            s.contact_name ,
            sum(s.score) as score ,
            sum(s.tie_breaker_1) as tie_breaker_1 ,
            sum(s.tie_breaker_2) as tie_breaker_2 ,
            sum(s.tie_breaker_3) as tie_breaker_3 ,
            sum(s.tie_breaker_4) as tie_breaker_4
        from v_individual_ranking s
        inner join contacts c on s.contact_id = c.id
        left join contact_companies cmp on c.company_id = cmp.id
        group by
            s.category_id ,
            s.category_name ,
            cmp.id,
            cmp.name,
            s.contact_id ,
            s.contact_name
        order by
            sum(s.tie_breaker_1) desc,
            sum(s.tie_breaker_2) desc,
            sum(s.tie_breaker_3) desc,
            sum(s.tie_breaker_4) desc
        ");

        DB::statement("
        create or replace view v_team_completion as
        select
            e.id as event_id ,
            e.name as event_name ,
            cat.id as category_id ,
            cat.name as category_name , 
            cc.id as company_id ,
            cc.name as company_name ,
            COALESCE(event_team_completion.participant_count, 0) as participant_count ,
            COALESCE(event_team_completion.submitted_score_count, 0) as submitted_score_count,
            case
                when COALESCE(event_team_completion.participant_count, 0) <= 0 then 100.00
                else COALESCE(event_team_completion.percent_complete, 0)
            end percent_complete
        from contact_companies cc
        join events e
        left join categories cat on cc.category_id = cat.id
        left join (
            /* event_team_completion - Get the completion summary by event and category */
            select
                e.id as event_id ,
                e.name as event_name ,
                team_participants.company_id ,
                team_participants.company_name ,
                team_participants.participant_count ,
                COALESCE(submitted_scores.submitted_score_count, 0) as submitted_score_count ,
                (COALESCE(submitted_scores.submitted_score_count, 0) / team_participants.participant_count) * 100 as percent_complete
            from events e
            join (
                /* team_participants - Get the total participants in a team */
                select
                    c.company_id ,
                    cmp.name as company_name ,
                    count(*) as participant_count
                from contacts c
                inner join contact_companies cmp on c.company_id = cmp.id
                /*where c.deleted_at is null and cmp.deleted_at is null*/
                group by c.company_id
            ) team_participants
            left join (
                /* submitted_scores - Get the number of scores turned in for an event by team */
                select
                    s.company_id ,
                    cmp.name as company_name ,
                    s.event_id ,
                    e.name as event_name ,
                    count(*) as submitted_score_count
                from scores s
                inner join events e on s.event_id = e.id
                inner join contact_companies cmp on s.company_id = cmp.id
                where s.deleted_at is null
                and e.deleted_at is null
                group by s.event_id, s.company_id
            ) submitted_scores on e.id = submitted_scores.event_id and team_participants.company_id = submitted_scores.company_id
        ) event_team_completion on e.id = event_team_completion.event_id and cc.id = event_team_completion.company_id
        where e.deleted_at is null
        and cat.deleted_at is null
        /*and cc.deleted_at is null*/
        order by cc.name, e.name
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
        left join (
            /* event_category_completion - Get the completion summary by event and category */
            select
                e.id as event_id ,
                e.name as event_name ,
                category_paricipants.category_id ,
                category_paricipants.category_name ,
                category_paricipants.participant_count ,
                COALESCE(submitted_scores.submitted_score_count, 0) as submitted_score_count ,
                (COALESCE(submitted_scores.submitted_score_count, 0) / category_paricipants.participant_count) * 100 as percent_complete
            from events e
            join (
                /* category_paricipants - Get the total participants in a category */
                select
                    c.category_id ,
                    cat.name as category_name,
                    count(*) as participant_count
                from contacts c
                inner join categories cat on c.category_id = cat.id
                where cat.deleted_at is null
                /*and c.deleted_at is null*/
                group by c.category_id, cat.name
            ) category_paricipants
            left join (
                /* submitted_scores - Get the number of scores turned in for a event / category */
                select
                    s.event_id ,
                    e.name as event_name ,
                    c.category_id ,
                    cat.name as category_name ,
                    count(*) as submitted_score_count
                from scores s
                inner join events e on s.event_id = e.id
                inner join contacts c on s.contact_id = c.id
                inner join categories cat on c.category_id = cat.id
                where s.deleted_at is null
                and e.deleted_at is null
                /*and c.deleted_at is null*/
                and cat.deleted_at is null
                group by s.event_id, cat.id 
            ) submitted_scores on e.id = submitted_scores.event_id and category_paricipants.category_id = submitted_scores.category_id
        ) event_category_completion on e.id = event_category_completion.event_id and cat.id = event_category_completion.category_id
        where cat.deleted_at is null
        and e.deleted_at is null
        order by cat.name, e.name
        ");        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_category_completion");
        DB::statement("DROP VIEW v_team_completion");
        DB::statement("DROP VIEW v_overall_ranking");
        DB::statement("DROP VIEW v_team_ranking");
        DB::statement("DROP VIEW v_individual_ranking");
        DB::statement("DROP VIEW v_individual_tie_breaker_1");
        DB::statement("DROP VIEW v_individual_tie_breaker_2");
        DB::statement("DROP VIEW v_individual_tie_breaker_3");
        DB::statement("DROP VIEW v_individual_tie_breaker_4");
    }
}
