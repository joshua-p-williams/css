<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c8eff5956baaRelationshipsToContactCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_companies', function(Blueprint $table) {
            if (!Schema::hasColumn('contact_companies', 'category_id')) {
                $table->integer('category_id')->unsigned()->nullable();
                $table->foreign('category_id', '31872_5c8eff58c4e7a')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::table('contact_companies', function(Blueprint $table) {
            
        });
    }
}
