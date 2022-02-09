<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosDiscountDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pos_discount_desktops')) {

            Schema::create('pos_discount_desktops', function (Blueprint $table) {
                $table->id();
                $table->string('id_store');
                $table->string('id_item');
                $table->string('id_kategori');
                $table->integer('discount');
                $table->integer('min_order');
                $table->string('sp_con')->nullable();
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
        Schema::dropIfExists('pos_discount_desktops');
    }
}
