<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c8b1bdd19433RelationshipsToScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scores', function(Blueprint $table) {
            if (!Schema::hasColumn('scores', 'event_id')) {
                $table->integer('event_id')->unsigned()->nullable();
                $table->foreign('event_id', '31828_5c8ac1ed58ace')->references('id')->on('events')->onDelete('cascade');
                }
                if (!Schema::hasColumn('scores', 'team_id')) {
                $table->integer('team_id')->unsigned()->nullable();
                $table->foreign('team_id', '31828_5c8b1bdc828e8')->references('id')->on('participant_teams')->onDelete('cascade');
                }
                if (!Schema::hasColumn('scores', 'participant_id')) {
                $table->integer('participant_id')->unsigned()->nullable();
                $table->foreign('participant_id', '31828_5c8b1b95972b7')->references('id')->on('participants')->onDelete('cascade');
                }
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scores', function(Blueprint $table) {
            
        });
    }
}
