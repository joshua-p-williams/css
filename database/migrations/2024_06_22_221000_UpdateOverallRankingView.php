<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOverallRankingView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW v_overall_ranking AS
            SELECT
                s.category_id,
                s.category_name,
                cmp.id AS team_id,
                cmp.name AS team_name,
                s.participant_id,
                s.participant_name,
                SUM(s.score) AS score,
                CASE 
                    WHEN (SELECT xcount_for_tb FROM settings ORDER BY id LIMIT 1) = 0 THEN MAX(s.tie_breaker_1)
                    ELSE SUM(s.tie_breaker_1)
                END AS tie_breaker_1,
                MAX(s.tie_breaker_2) AS tie_breaker_2,
                MAX(s.tie_breaker_3) AS tie_breaker_3,
                MAX(s.tie_breaker_4) AS tie_breaker_4,
                DENSE_RANK() OVER (
                    PARTITION BY s.category_id
                    ORDER BY 
                    SUM(s.score) DESC, 
                    CASE 
                        WHEN (SELECT xcount_for_tb FROM settings ORDER BY id LIMIT 1) = 0 THEN MAX(s.tie_breaker_1)
                        ELSE SUM(s.tie_breaker_1)
                    END DESC,
                    MAX(s.tie_breaker_2) DESC,
                    MAX(s.tie_breaker_3) DESC,
                    MAX(s.tie_breaker_4) DESC
                ) AS ranking
            FROM v_individual_ranking s
            INNER JOIN participants c ON s.participant_id = c.id
            LEFT JOIN teams cmp ON c.team_id = cmp.id
            GROUP BY
                s.category_id,
                s.category_name,
                cmp.id,
                cmp.name,
                s.participant_id,
                s.participant_name;
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
            CREATE OR REPLACE VIEW v_overall_ranking AS
            SELECT
                s.category_id,
                s.category_name,
                cmp.id AS team_id,
                cmp.name AS team_name,
                s.participant_id,
                s.participant_name,
                SUM(s.score) AS score,
                s.tie_breaker_1,
                s.tie_breaker_2,
                s.tie_breaker_3,
                s.tie_breaker_4,
                DENSE_RANK() OVER (
                    PARTITION BY s.category_id 
                    ORDER BY 
                    SUM(s.score) DESC, 
                    s.tie_breaker_1 DESC,
                    s.tie_breaker_2 DESC,
                    s.tie_breaker_3 DESC,
                    s.tie_breaker_4 DESC
                ) AS ranking
            FROM v_individual_ranking s
            INNER JOIN participants c ON s.participant_id = c.id
            LEFT JOIN teams cmp ON c.team_id = cmp.id
            GROUP BY
                s.category_id,
                s.category_name,
                cmp.id,
                cmp.name,
                s.participant_id,
                s.participant_name,
                s.tie_breaker_1,
                s.tie_breaker_2,
                s.tie_breaker_3,
                s.tie_breaker_4;
        ");
    }
}
