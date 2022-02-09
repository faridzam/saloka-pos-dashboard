<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosKategoriDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pos_kategori_desktops')) {

            Schema::create('pos_kategori_desktops', function (Blueprint $table) {
                $table->id();
                $table->string('id_kategori');
                $table->string('nama_kategori');
                $table->integer('isDell');
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
        Schema::dropIfExists('pos_kategori_desktops');
    }
}
