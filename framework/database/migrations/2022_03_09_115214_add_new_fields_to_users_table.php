<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('contact')->nullable()->after('email');
            $table->enum('role', ['engineer', 'it-admin', 'it-staff', 'fa-admin', 'fa-staff', 'ir-admin', 'ir-staff', 'fnb-admin', 'fnb-staff', 'common-user', 'viewer', 'man-fin', 'man-ir', 'man-fnb', 'man-it'])->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
