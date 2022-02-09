<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pos_activity_and_desktop extends Model
{
    //
    protected $fillable = [
        'no_invoice',
        'id_store',
        'metode',
        'id_kasir',
        'total_pembelian',
        'total_bayar',
        'kembalian',
        'no_co',
        'note',
    ];
}
