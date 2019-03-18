<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c8b1b961ddd9RelationshipsToScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scores', function(Blueprint $table) {
            if (!Schema::hasColumn('scores', 'contact_id')) {
                $table->integer('contact_id')->unsigned()->nullable();
                $table->foreign('contact_id', '31828_5c8b1b95972b7')->references('id')->on('contacts')->onDelete('cascade');
                }
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
