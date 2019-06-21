<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddXcount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->integer('xcount')->nullable();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('xcount_for_tb')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->dropColumn('xcount');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('xcount_for_tb');
        });
    }
}
