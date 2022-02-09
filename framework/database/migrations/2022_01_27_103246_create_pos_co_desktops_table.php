<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosCoDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pos_co_desktops')) {

            Schema::create('pos_co_desktops', function (Blueprint $table) {
                $table->id();
                $table->string('kasir');
                $table->string('no_co');
                $table->bigInteger('deposit');
                $table->bigInteger('omset');
                $table->bigInteger('profit');
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
        Schema::dropIfExists('pos_co_desktops');
    }
}
