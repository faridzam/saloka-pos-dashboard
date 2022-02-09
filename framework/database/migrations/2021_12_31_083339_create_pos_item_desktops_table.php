<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosItemDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pos_item_desktops')) {

            Schema::create('pos_item_desktops', function (Blueprint $table) {
                $table->id();
                $table->string('id_item');
                $table->string('nama_item');
                $table->double('hpp');
                $table->double('harga');
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
        Schema::dropIfExists('pos_item_desktops');
    }
}
