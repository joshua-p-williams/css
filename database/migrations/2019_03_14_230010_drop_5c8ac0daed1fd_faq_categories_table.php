<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Drop5c8ac0daed1fdFaqCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('faq_categories');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(! Schema::hasTable('faq_categories')) {
            Schema::create('faq_categories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                
                $table->timestamps();
                
            });
        }
    }
}
