<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosStoreDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pos_store_desktops')) {
            Schema::create('pos_store_desktops', function (Blueprint $table) {
                $table->id();
                $table->string('id_store');
                $table->string('kode_store');
                $table->string('nama_store');
                $table->string('ip_kasir');
                $table->string('ip_kitchen');
                $table->string('ip_bar');
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
        Schema::dropIfExists('pos_store_desktops');
    }
}
