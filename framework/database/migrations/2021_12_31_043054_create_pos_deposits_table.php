<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pos_deposits')) {
            Schema::create('pos_deposits', function (Blueprint $table) {

                $table->id();
                $table->string('id_store');
                $table->string('admin');
                $table->integer('pec100');
                $table->integer('pec50');
                $table->integer('pec20');
                $table->integer('pec10');
                $table->integer('pec5');
                $table->integer('pec2');
                $table->integer('pec1');
                $table->bigInteger('nominal');
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
        Schema::dropIfExists('pos_deposits');
    }
}
