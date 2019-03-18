<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c8ac156f2c81RelationshipsToParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants', function(Blueprint $table) {
            if (!Schema::hasColumn('participants', 'category_id')) {
                $table->integer('category_id')->unsigned()->nullable();
                $table->foreign('category_id', '31720_5c89a26a01864')->references('id')->on('categories')->onDelete('cascade');
                }
                if (!Schema::hasColumn('participants', 'team_id')) {
                $table->integer('team_id')->unsigned()->nullable();
                $table->foreign('team_id', '31720_5c89a26a0697f')->references('id')->on('teams')->onDelete('cascade');
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
        Schema::table('participants', function(Blueprint $table) {
            
        });
    }
}
