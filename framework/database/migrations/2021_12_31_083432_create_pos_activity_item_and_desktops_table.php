<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosActivityItemAndDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pos_activity_item_and_desktops')) {

            Schema::create('pos_activity_item_and_desktops', function (Blueprint $table) {
                $table->id();
                $table->string('no_invoice');
                $table->string('id_kategori');
                $table->string('id_item');
                $table->string('nama_item');
                $table->integer('qty');
                $table->double('hpp');
                $table->double('harga');
                $table->double('total');
                $table->text('id_store');
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
        Schema::dropIfExists('pos_activity_item_and_desktops');
    }
}
