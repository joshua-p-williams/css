<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c8b1aee8fa3eRelationshipsToScoreTable extends Migration
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
