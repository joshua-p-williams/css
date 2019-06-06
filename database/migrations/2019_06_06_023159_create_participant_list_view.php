<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantListView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        create or replace view v_participant_list as
        select p.id as participant_id
        , c.name as category
        , t.name as team
        , p.name as participant
        from teams t
        left join categories c on t.category_id = c.id
        left join participants p on t.id = p.team_id
        order by c.name, t.name, p.name
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_participant_list");
    }
}
