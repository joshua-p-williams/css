<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c8ac14dace66RelationshipsToTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function(Blueprint $table) {
            if (!Schema::hasColumn('teams', 'category_id')) {
                $table->integer('category_id')->unsigned()->nullable();
                $table->foreign('category_id', '31719_5c89a1e3500fb')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::table('teams', function(Blueprint $table) {
            
        });
    }
}
