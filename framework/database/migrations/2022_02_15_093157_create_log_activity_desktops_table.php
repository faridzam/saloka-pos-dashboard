<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActivityDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        if (!Schema::hasTable('log_activity_desktops')) {
            
            Schema::create('log_activity_desktops', function (Blueprint $table) {
                $table->id();
                $table->string('pic');
                $table->enum('tipe', ['read', 'create', 'update', 'delete', 'loginKasir', 'logoutKasir', 'loginDashboard', 'logoutDashboard', 'break', 'backToWork', 'closeOrder']);
                $table->string('keterangan');
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
        Schema::dropIfExists('log_activity_desktops');
    }
}
