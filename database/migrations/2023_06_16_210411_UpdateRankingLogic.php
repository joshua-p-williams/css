<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRankingLogic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
            sum(s.tie_breaker_4) as tie_breaker_4 ,
            DENSE_RANK() OVER (
            	PARTITION BY s.category_id 
            	ORDER BY 
            	sum(s.score) DESC , 
            	sum(s.tie_breaker_1) DESC ,
            	sum(s.tie_breaker_2) DESC ,
            	sum(s.tie_breaker_3) DESC ,
            	sum(s.tie_breaker_4) DESC
            ) AS ranking
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
        create or replace view v_overall_team_ranking as
        select overall_team.category_id
             , overall_team.category_name
             , overall_team.team_id
             , overall_team.team_name
             , sum(overall_team.score) as score
             , sum(overall_team.tie_breaker_1) as tie_breaker_1
             , sum(overall_team.tie_breaker_2) as tie_breaker_2
             , sum(overall_team.tie_breaker_3) as tie_breaker_3
             , sum(overall_team.tie_breaker_4) as tie_breaker_4
	         , DENSE_RANK() OVER (
	            	PARTITION BY overall_team.category_id 
	            	ORDER BY 
	            	sum(overall_team.score) DESC , 
	            	sum(overall_team.tie_breaker_1) DESC ,
	            	sum(overall_team.tie_breaker_2) DESC ,
	            	sum(overall_team.tie_breaker_3) DESC ,
	            	sum(overall_team.tie_breaker_4) DESC
	           ) AS ranking             
        from (
                select ranked.category_id,
                ranked.category_name,
                ranked.team_id,
                ranked.team_name,
                sum(ranked.score) as score ,
                ranked.tie_breaker_1 as tie_breaker_1 ,
                ranked.tie_breaker_2 as tie_breaker_2 ,
                ranked.tie_breaker_3 as tie_breaker_3 ,
                ranked.tie_breaker_4 as tie_breaker_4
                from (
                    select a.category_id,
                    a.category_name,
                    a.team_id,
                    a.team_name,
                    a.participant_id,
                    a.participant_name,
                    a.score ,
                    a.tie_breaker_1 ,
                    a.tie_breaker_2 ,
                    a.tie_breaker_3 ,
                    a.tie_breaker_4 ,
                    (
                        select count(*) + 1 from v_individual_ranking b 
                        where b.exclude_team_rank = 0
                        and b.category_id = a.category_id
                        and b.event_id = a.event_id
                        and b.team_id = a.team_id
                        and ((a.score * 100000000000) + (a.tie_breaker_1 * 100000000) + (a.tie_breaker_2 * 100000) + (a.tie_breaker_3 * 100) + a.tie_breaker_4)
                        < ((b.score * 100000000000) + (b.tie_breaker_1 * 100000000) + (b.tie_breaker_2 * 100000) + (b.tie_breaker_3 * 100) + b.tie_breaker_4)
                    ) as rank_num
                    from v_individual_ranking a
                    where a.exclude_team_rank = 0
                ) ranked
                where ranked.rank_num <= (select top_scores_keep from settings order by id limit 1)
                group by
                    ranked.category_id ,
                    ranked.category_name ,
                    ranked.team_id ,
                    ranked.team_name ,
                    ranked.tie_breaker_1 ,
                    ranked.tie_breaker_2 ,
                    ranked.tie_breaker_3 ,
                    ranked.tie_breaker_4
        ) as overall_team
        group by
            overall_team.category_id ,
            overall_team.category_name ,
            overall_team.team_id ,
            overall_team.team_name
        order by
            overall_team.category_name,
            sum(overall_team.score) desc,
            sum(overall_team.tie_breaker_1) desc,    
            sum(overall_team.tie_breaker_2) desc,    
            sum(overall_team.tie_breaker_3) desc,    
            sum(overall_team.tie_breaker_4) desc    
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
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
            case when ((select xcount_for_tb from settings order by id limit 1) = 0) 
            	then max(s.tie_breaker_1)
            	else sum(s.tie_breaker_1)
            end as tie_breaker_1 ,
            max(s.tie_breaker_2) as tie_breaker_2 ,
            max(s.tie_breaker_3) as tie_breaker_3 ,
            max(s.tie_breaker_4) as tie_breaker_4
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
            case when ((select xcount_for_tb from settings order by id limit 1) = 0) 
            	then max(s.tie_breaker_1)
            	else sum(s.tie_breaker_1)
            end desc ,
            sum(s.tie_breaker_2) desc,
            sum(s.tie_breaker_3) desc,
            sum(s.tie_breaker_4) desc
        ");

        DB::statement("
        create or replace view v_overall_team_ranking as
        select overall_team.category_id
             , overall_team.category_name
             , overall_team.team_id
             , overall_team.team_name
             , sum(overall_team.score) as score
             , sum(overall_team.tie_breaker_1) as tie_breaker_1
             , sum(overall_team.tie_breaker_2) as tie_breaker_2
             , sum(overall_team.tie_breaker_3) as tie_breaker_3
             , sum(overall_team.tie_breaker_4) as tie_breaker_4
        from (
                select ranked.category_id,
                ranked.category_name,
                ranked.team_id,
                ranked.team_name,
                sum(ranked.score) as score ,
                ranked.tie_breaker_1 as tie_breaker_1 ,
                ranked.tie_breaker_2 as tie_breaker_2 ,
                ranked.tie_breaker_3 as tie_breaker_3 ,
                ranked.tie_breaker_4 as tie_breaker_4
                from (
                    select a.category_id,
                    a.category_name,
                    a.team_id,
                    a.team_name,
                    a.participant_id,
                    a.participant_name,
                    a.score ,
                    a.tie_breaker_1 ,
                    a.tie_breaker_2 ,
                    a.tie_breaker_3 ,
                    a.tie_breaker_4 ,
                    (
                        select count(*) + 1 from v_individual_ranking b 
                        where b.exclude_team_rank = 0
                        and b.category_id = a.category_id
                        and b.event_id = a.event_id
                        and b.team_id = a.team_id
                        and ((a.score * 100000000000) + (a.tie_breaker_1 * 100000000) + (a.tie_breaker_2 * 100000) + (a.tie_breaker_3 * 100) + a.tie_breaker_4)
                        < ((b.score * 100000000000) + (b.tie_breaker_1 * 100000000) + (b.tie_breaker_2 * 100000) + (b.tie_breaker_3 * 100) + b.tie_breaker_4)
                    ) as rank_num
                    from v_individual_ranking a
                    where a.exclude_team_rank = 0
                ) ranked
                where ranked.rank_num <= (select top_scores_keep from settings order by id limit 1)
                group by
                    ranked.category_id ,
                    ranked.category_name ,
                    ranked.team_id ,
                    ranked.team_name ,
                    ranked.tie_breaker_1 ,
                    ranked.tie_breaker_2 ,
                    ranked.tie_breaker_3 ,
                    ranked.tie_breaker_4
        ) as overall_team
        group by
            overall_team.category_id ,
            overall_team.category_name ,
            overall_team.team_id ,
            overall_team.team_name
        order by
            overall_team.category_name,
            sum(overall_team.score) desc,
            sum(overall_team.tie_breaker_1) desc,    
            sum(overall_team.tie_breaker_2) desc,    
            sum(overall_team.tie_breaker_3) desc,    
            sum(overall_team.tie_breaker_4) desc    
        ");

    }
}
