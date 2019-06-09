<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAllResultsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        create or replace view v_all_results as        
        select category_name
        , team_name
        , participant_name
        , MAX(total_score) as total_score
        , MAX(tie_breaker_1) as tie_breaker_1
        , MAX(tie_breaker_2) as tie_breaker_2
        , MAX(tie_breaker_3) as tie_breaker_3
        , MAX(tie_breaker_4) as tie_breaker_4
        , sum(archery) as archery
        , sum(shotgun) as shotgun
        , sum(rifle) as rifle
        , sum(muzzleloader) as muzzleloader
        , sum(responsibility_exam) as responsibility_exam
        , sum(safety_trail) as safety_trail
        , sum(wildlife_id) as wildlife_id
        , sum(orienteering) as orienteering
        from (
            select category_name
            , team_name
            , participant_name
            , sum(score) as total_score
            , MAX(tie_breaker_1) as tie_breaker_1
            , MAX(tie_breaker_2) as tie_breaker_2
            , MAX(tie_breaker_3) as tie_breaker_3
            , MAX(tie_breaker_4) as tie_breaker_4
            , MAX(IF(event_name = 'Archery', score, NULL)) AS archery
            , MAX(IF(event_name = 'Shotgun', score, NULL)) AS shotgun
            , MAX(IF(event_name = 'Rifle', score, NULL)) AS rifle
            , MAX(IF(event_name = 'Muzzleloader', score, NULL)) AS muzzleloader
            , MAX(IF(event_name = 'Responsibility Exam', score, NULL)) AS responsibility_exam
            , MAX(IF(event_name = 'Safety Trail', score, NULL)) AS safety_trail
            , MAX(IF(event_name = 'Wildlife Identification', score, NULL)) AS wildlife_id
            , MAX(IF(event_name = 'Orienteering', score, NULL)) AS orienteering
            from v_individual_ranking 
            group by category_name
            , team_name
            , participant_name
            , score
        ) pvt
        group by category_name
        , team_name
        , participant_name
        order by total_score DESC
        , tie_breaker_1 DESC
        , tie_breaker_2 DESC
        , tie_breaker_3 DESC
        , tie_breaker_4 DESC
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new CreateAllResultsView())->up();
    }
}
