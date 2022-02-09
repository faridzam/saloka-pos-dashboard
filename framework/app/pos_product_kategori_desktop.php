<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pos_product_kategori_desktop extends Model
{
    //
    protected $fillable = [
        'id_kategori',
        'id_store',
        'nama_kategori',
        'isDell',
    ];
}
