<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1552620384ParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants', function (Blueprint $table) {
            if(Schema::hasColumn('participants', 'first_name')) {
                $table->dropColumn('first_name');
            }
            if(Schema::hasColumn('participants', 'last_name')) {
                $table->dropColumn('last_name');
            }
            if(Schema::hasColumn('participants', 'phone1')) {
                $table->dropColumn('phone1');
            }
            if(Schema::hasColumn('participants', 'phone2')) {
                $table->dropColumn('phone2');
            }
            
        });
Schema::table('participants', function (Blueprint $table) {
            
if (!Schema::hasColumn('participants', 'name')) {
                $table->string('name');
                }
if (!Schema::hasColumn('participants', 'phone')) {
                $table->string('phone')->nullable();
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
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('phone');
            
        });
Schema::table('participants', function (Blueprint $table) {
                        $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('phone1')->nullable();
                $table->string('phone2')->nullable();
                
        });

    }
}
