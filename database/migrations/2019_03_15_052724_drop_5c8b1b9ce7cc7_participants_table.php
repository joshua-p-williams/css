<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Drop5c8b1b9ce7cc7ParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('participants');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(! Schema::hasTable('participants')) {
            Schema::create('participants', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                
                $table->timestamps();
                $table->softDeletes();

            $table->index(['deleted_at']);
            });
        }
    }
}
