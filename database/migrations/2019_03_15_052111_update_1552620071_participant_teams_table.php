<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1552620071ParticipantTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participant_teams', function (Blueprint $table) {
            if(Schema::hasColumn('participant_teams', 'address')) {
                $table->dropColumn('address');
            }
            if(Schema::hasColumn('participant_teams', 'website')) {
                $table->dropColumn('website');
            }
            if(Schema::hasColumn('participant_teams', 'email')) {
                $table->dropColumn('email');
            }
            
        });
Schema::table('participant_teams', function (Blueprint $table) {
            
if (!Schema::hasColumn('participant_teams', 'primary_contact_name')) {
                $table->string('primary_contact_name');
                }
if (!Schema::hasColumn('participant_teams', 'primary_contact_phone')) {
                $table->string('primary_contact_phone')->nullable();
                }
if (!Schema::hasColumn('participant_teams', 'primary_contact_email')) {
                $table->string('primary_contact_email')->nullable();
                }
if (!Schema::hasColumn('participant_teams', 'state')) {
                $table->string('state')->nullable();
                }
if (!Schema::hasColumn('participant_teams', 'county')) {
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
        Schema::table('participant_teams', function (Blueprint $table) {
            $table->dropColumn('primary_contact_name');
            $table->dropColumn('primary_contact_phone');
            $table->dropColumn('primary_contact_email');
            $table->dropColumn('state');
            $table->dropColumn('county');
            
        });
Schema::table('participant_teams', function (Blueprint $table) {
                        $table->string('address')->nullable();
                $table->string('website')->nullable();
                $table->string('email')->nullable();
                
        });

    }
}
