<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c8b191c88740RelationshipsToContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function(Blueprint $table) {
            if (!Schema::hasColumn('contacts', 'company_id')) {
                $table->integer('company_id')->unsigned()->nullable();
                $table->foreign('company_id', '31873_5c8b17790d479')->references('id')->on('contact_companies')->onDelete('cascade');
                }
                if (!Schema::hasColumn('contacts', 'category_id')) {
                $table->integer('category_id')->unsigned()->nullable();
                $table->foreign('category_id', '31873_5c8b190329af6')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::table('contacts', function(Blueprint $table) {
            
        });
    }
}
