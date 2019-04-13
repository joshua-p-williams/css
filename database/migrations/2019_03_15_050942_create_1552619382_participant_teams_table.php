<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1552619382ParticipantTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('participant_teams')) {
            Schema::create('participant_teams', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('address')->nullable();
                $table->string('website')->nullable();
                $table->string('email')->nullable();
                
                $table->timestamps();
                
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant_teams');
    }
}