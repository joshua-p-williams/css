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
        CREATE OR REPLACE VIEW v_score_summary as
        select
            e.id as event_id ,
            e.name as event_name ,
            cmp.category_id ,
            cat.name as category_name ,
            s.company_id ,
            cmp.name as company_name ,
            s.contact_id ,
            c.name as contact_name ,
            s.id as score_id ,
            s.score
        from
            events e
        left join scores s on
            e.id = s.event_id
        left join contacts c on
            s.contact_id = c.id
        left join contact_companies cmp on
            s.company_id = cmp.id
        left join categories cat on
            cmp.category_id = cat.id           
        ");

        DB::statement("
        CREATE OR REPLACE VIEW v_team_ranking as 
        select
            s.event_id ,
            s.event_name ,
            s.category_id ,
            s.category_name ,
            s.company_id ,
            s.company_name ,
            sum(s.score) as total_score
        from
            v_score_summary s
        group by
            s.category_id ,
            s.category_name ,
            s.event_id ,
            s.event_name ,
            s.company_id ,
            s.company_name
        order by
            s.event_name,
            s.category_name,
            sum(s.score) DESC             
        ");

        DB::statement("
        CREATE OR REPLACE VIEW v_individual_ranking as
        select
            s.event_id ,
            s.event_name ,
            s.category_id ,
            s.category_name ,
            s.contact_id ,
            s.contact_name ,
            s.score
        from
            v_score_summary s
        order by
            s.event_name,
            s.category_name,
            s.score desc
        ");

        DB::statement("
        CREATE OR REPLACE VIEW v_event_category_completion as
        select
            cat.id as category_id ,
            cat.name as category_name ,
            e.id as event_id ,
            e.name as event_name ,
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
                submitted_scores.category_id ,
                submitted_scores.category_name ,
                category_paricipants.participant_count ,
                submitted_scores.submitted_score_count as submitted_score_count ,
                (submitted_scores.submitted_score_count / category_paricipants.participant_count) * 100 as percent_complete
            from events e
            inner join (
                /* submitted_scores - Get the number of scores turned in for a event / category */
                select
                    s.event_id ,
                    e.name as event_name ,
                    c.category_id ,
                    cat.name as category_name ,
                    count(*) as submitted_score_count
                from
                    scores s
                inner join events e on s.event_id = e.id
                inner join contacts c on s.contact_id = c.id
                inner join categories cat on c.category_id = cat.id
                group by s.event_id, cat.id 
            ) submitted_scores on e.id = submitted_scores.event_id
            inner join (
                /* category_paricipants - Get the total participants in a category */
                select
                    c.category_id ,
                    count(*) as participant_count
                from contacts c
                group by c.category_id 
            ) category_paricipants on submitted_scores.category_id = category_paricipants.category_id 
        ) event_category_completion on e.id = event_category_completion.event_id and cat.id = event_category_completion.category_id
        order by cat.name, e.name
        ");

        DB::statement("
        CREATE OR REPLACE VIEW v_event_team_completion as
        select
            cc.id as company_id ,
            cc.name as company_name ,
            cat.id as category_id ,
            cat.name as category_name , 
            e.id as event_id ,
            e.name as event_name ,
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
                submitted_scores.company_id ,
                submitted_scores.company_name ,
                team_participants.participant_count ,
                submitted_scores.submitted_score_count as submitted_score_count ,
                (submitted_scores.submitted_score_count / team_participants.participant_count) * 100 as percent_complete
            from events e
            inner join (
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
                group by s.event_id, s.company_id
            ) submitted_scores on e.id = submitted_scores.event_id
            inner join (
                /* team_participants - Get the total participants in a team */
                select
                    c.company_id ,
                    cmp.name as company_name ,
                    count(*) as participant_count
                from contacts c
                inner join contact_companies cmp on c.company_id = cmp.id
                group by
                    c.company_id
            ) team_participants on submitted_scores.company_id = team_participants.company_id 
        ) event_team_completion on e.id = event_team_completion.event_id and cc.id = event_team_completion.company_id
        order by cc.name, e.name
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_event_team_completion");
        DB::statement("DROP VIEW v_event_category_completion");
        DB::statement("DROP VIEW v_individual_ranking");
        DB::statement("DROP VIEW v_team_ranking");
        DB::statement("DROP VIEW v_score_summary");
    }
}
