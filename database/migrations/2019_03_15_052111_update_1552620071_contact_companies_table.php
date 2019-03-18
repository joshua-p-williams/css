<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1552620071ContactCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_companies', function (Blueprint $table) {
            if(Schema::hasColumn('contact_companies', 'address')) {
                $table->dropColumn('address');
            }
            if(Schema::hasColumn('contact_companies', 'website')) {
                $table->dropColumn('website');
            }
            if(Schema::hasColumn('contact_companies', 'email')) {
                $table->dropColumn('email');
            }
            
        });
Schema::table('contact_companies', function (Blueprint $table) {
            
if (!Schema::hasColumn('contact_companies', 'primary_contact_name')) {
                $table->string('primary_contact_name');
                }
if (!Schema::hasColumn('contact_companies', 'primary_contact_phone')) {
                $table->string('primary_contact_phone')->nullable();
                }
if (!Schema::hasColumn('contact_companies', 'primary_contact_email')) {
                $table->string('primary_contact_email')->nullable();
                }
if (!Schema::hasColumn('contact_companies', 'state')) {
                $table->string('state')->nullable();
                }
if (!Schema::hasColumn('contact_companies', 'county')) {
                $table->string('county')->nullable();
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
        Schema::table('contact_companies', function (Blueprint $table) {
            $table->dropColumn('primary_contact_name');
            $table->dropColumn('primary_contact_phone');
            $table->dropColumn('primary_contact_email');
            $table->dropColumn('state');
            $table->dropColumn('county');
            
        });
Schema::table('contact_companies', function (Blueprint $table) {
                        $table->string('address')->nullable();
                $table->string('website')->nullable();
                $table->string('email')->nullable();
                
        });

    }
}
