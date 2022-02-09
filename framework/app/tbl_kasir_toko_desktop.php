<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_kasir_toko_desktop extends Model
{
    //
    protected $fillable = [
        'id_kasir',
        'id_toko',
    ];
}
