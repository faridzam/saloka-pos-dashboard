<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblKasirTokoDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_kasir_toko_desktops')) {

            Schema::create('tbl_kasir_toko_desktops', function (Blueprint $table) {
                $table->id();
                $table->string('id_kasir');
                $table->string('id_toko');
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
        Schema::dropIfExists('tbl_kasir_toko_desktops');
    }
}
