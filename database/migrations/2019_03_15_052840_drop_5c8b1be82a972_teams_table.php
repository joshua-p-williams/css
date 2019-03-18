<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Drop5c8b1be82a972TeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('teams');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(! Schema::hasTable('teams')) {
            Schema::create('teams', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                
                $table->timestamps();
                $table->softDeletes();

            $table->index(['deleted_at']);
            });
        }
    }
}
