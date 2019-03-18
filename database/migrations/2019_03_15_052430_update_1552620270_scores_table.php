<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1552620270ScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scores', function (Blueprint $table) {
            if(Schema::hasColumn('scores', 'participant_id')) {
                $table->dropForeign('31828_5c8ac1ed5d241');
                $table->dropIndex('31828_5c8ac1ed5d241');
                $table->dropColumn('participant_id');
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
        Schema::table('scores', function (Blueprint $table) {
                        
        });

    }
}
