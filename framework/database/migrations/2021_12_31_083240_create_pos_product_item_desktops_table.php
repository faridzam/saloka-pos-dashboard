<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosProductItemDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pos_product_item_desktops')) {
            Schema::create('pos_product_item_desktops', function (Blueprint $table) {
                $table->id();
                $table->string('id_item');
                $table->string('nama_item');
                $table->string('id_kategori');
                $table->string('id_store');
                $table->double('harga');
                $table->double('pajak');
                $table->double('harga_jual');
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
        Schema::dropIfExists('pos_product_item_desktops');
    }
}
