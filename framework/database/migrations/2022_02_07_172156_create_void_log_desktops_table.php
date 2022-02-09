<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoidLogDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('void_log_desktops')) {

            Schema::create('void_log_desktops', function (Blueprint $table) {
                $table->id();
                $table->string('no_invoice');
                $table->string('kasir');
                $table->string('pic');
                $table->integer('id_store');
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
        Schema::dropIfExists('void_log_desktops');
    }
}
