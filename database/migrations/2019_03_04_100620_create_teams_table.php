<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('teams')) {
            Schema::create('teams', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('address')->nullable();
                $table->string('website')->nullable();
                $table->string('email')->nullable();
                $table->string('primary_contact_name');
                $table->string('primary_contact_phone')->nullable();
                $table->string('primary_contact_email')->nullable();
                $table->string('state')->nullable();
                $table->string('county')->nullable();
                $table->boolean('exclude_team_rank')->default(false);
                $table->boolean('exclude_ind_rank')->default(false);
    
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
        Schema::dropIfExists('teams');
    }
}
