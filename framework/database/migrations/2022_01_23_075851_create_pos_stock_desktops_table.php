<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosStockDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pos_stock_desktops')) {

            Schema::create('pos_stock_desktops', function (Blueprint $table) {
                $table->id();
                $table->string('id_store');
                $table->string('id_item');
                $table->string('nama_item');
                $table->bigInteger('qty');
                $table->integer('min_qty');
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
        Schema::dropIfExists('pos_stock_desktops');
    }
}
