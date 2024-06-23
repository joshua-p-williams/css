<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOverallTeamRankingView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW v_overall_team_ranking AS
            SELECT 
                a.category_id,
                a.category_name,
                a.team_id,
                a.team_name,
                SUM(a.score) AS score,
                CASE 
                    WHEN (SELECT xcount_for_tb FROM settings ORDER BY id LIMIT 1) = 0 THEN MAX(a.tie_breaker_1)
                    ELSE SUM(a.tie_breaker_1)
                END AS tie_breaker_1,
                MAX(a.tie_breaker_2) AS tie_breaker_2,
                MAX(a.tie_breaker_3) AS tie_breaker_3,
                MAX(a.tie_breaker_4) AS tie_breaker_4,
                DENSE_RANK() OVER (
                    PARTITION BY a.category_id
                    ORDER BY 
                    SUM(a.score) DESC, 
                    CASE 
                        WHEN (SELECT xcount_for_tb FROM settings ORDER BY id LIMIT 1) = 0 THEN MAX(a.tie_breaker_1)
                        ELSE SUM(a.tie_breaker_1)
                    END DESC,
                    MAX(a.tie_breaker_2) DESC,
                    MAX(a.tie_breaker_3) DESC,
                    MAX(a.tie_breaker_4) DESC
                ) AS ranking
            FROM v_team_ranking a
            GROUP BY
                a.category_id,
                a.category_name,
                a.team_id,
                a.team_name;
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
            CREATE OR REPLACE VIEW v_overall_team_ranking AS
            SELECT 
                a.category_id,
                a.category_name,
                a.team_id,
                a.team_name,
                SUM(a.score) AS score,
                a.tie_breaker_1 AS tie_breaker_1,
                a.tie_breaker_2 AS tie_breaker_2,
                a.tie_breaker_3 AS tie_breaker_3,
                a.tie_breaker_4 AS tie_breaker_4,
                DENSE_RANK() OVER (
                    PARTITION BY a.category_id
                    ORDER BY 
                    SUM(a.score) DESC, 
                    a.tie_breaker_1 DESC,
                    a.tie_breaker_2 DESC,
                    a.tie_breaker_3 DESC,
                    a.tie_breaker_4 DESC
                ) AS ranking
            FROM v_team_ranking a
            GROUP BY
                a.category_id,
                a.category_name,
                a.team_id,
                a.team_name,
                a.tie_breaker_1,
                a.tie_breaker_2,
                a.tie_breaker_3,
                a.tie_breaker_4;
        ");
    }
}
