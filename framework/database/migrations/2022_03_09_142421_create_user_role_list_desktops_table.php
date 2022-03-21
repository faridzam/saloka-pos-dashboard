<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleListDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_role_list_desktops')) {
            
            Schema::create('user_role_list_desktops', function (Blueprint $table) {
                $table->id();
                $table->enum('role', ['engineer', 'it-admin', 'it-staff', 'fa-admin', 'fa-staff', 'ir-admin', 'ir-staff', 'fnb-admin', 'fnb-staff', 'common-user', 'viewer', 'man-fin', 'man-ir', 'man-fnb', 'man-it']);
                $table->boolean('users');
                $table->boolean('users-kasir');
                $table->boolean('users-dashboard');
                $table->boolean('laporan-penjualan');
                $table->boolean('laporan-itemSales');
                $table->boolean('stock-management');
                $table->boolean('master-menu');
                $table->boolean('master-discount');
                $table->boolean('master-specialPrice');
                $table->boolean('void');
                $table->timestamps();
            });
        
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role_list_desktops');
    }
}
