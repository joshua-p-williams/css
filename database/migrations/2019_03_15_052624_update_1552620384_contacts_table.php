<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1552620384ContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            if(Schema::hasColumn('contacts', 'first_name')) {
                $table->dropColumn('first_name');
            }
            if(Schema::hasColumn('contacts', 'last_name')) {
                $table->dropColumn('last_name');
            }
            if(Schema::hasColumn('contacts', 'phone1')) {
                $table->dropColumn('phone1');
            }
            if(Schema::hasColumn('contacts', 'phone2')) {
                $table->dropColumn('phone2');
            }
            
        });
Schema::table('contacts', function (Blueprint $table) {
            
if (!Schema::hasColumn('contacts', 'name')) {
                $table->string('name');
                }
if (!Schema::hasColumn('contacts', 'phone')) {
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
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('phone');
            
        });
Schema::table('contacts', function (Blueprint $table) {
                        $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('phone1')->nullable();
                $table->string('phone2')->nullable();
                
        });

    }
}
