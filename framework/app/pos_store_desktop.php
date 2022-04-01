<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pos_store_desktop extends Model
{
    //
    protected $fillable = [
        'id',
        'id_store',
        'kode_store',
        'nama_store',
        'ip_kasir',
        'ip_kitchen',
        'ip_bar',
    ];
}
