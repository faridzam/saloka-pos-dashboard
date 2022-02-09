<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosActivityAndDesktopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('failed_jobs')) {

            Schema::create('pos_activity_and_desktops', function (Blueprint $table) {
                $table->id();
                $table->string('no_invoice');
                $table->enum('metode', ['tunai', 'bca_debit', 'bca_kredit', 'mandiri_debit', 'mandiri_kredit', 'bri_debit', 'bri_kredit', 'bni_debit', 'bni_kredit']);
                $table->string('id_store');
                $table->string('id_kasir');
                $table->double('total_pembelian');
                $table->double('total_bayar');
                $table->double('kembalian');
                $table->string('no_co');
                $table->string('note');
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
        Schema::dropIfExists('pos_activity_and_desktops');
    }
}
