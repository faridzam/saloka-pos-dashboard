<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pos_activity_item_and_desktop extends Model
{
    //
    protected $fillable = [
        'no_invoice',
        'id_kategori',
        'id_item',
        'nama_item',
        'qty',
        'hpp',
        'harga',
        'total',
        'id_store',
    ];
}
