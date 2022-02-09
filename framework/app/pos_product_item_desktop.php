<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pos_product_item_desktop extends Model
{
    //
    protected $fillable = [
        'id_item',
        'nama_item',
        'id_kategori',
        'id_store',
        'harga',
        'pajak',
        'harga_jual',
        'isDell',
    ];
}
