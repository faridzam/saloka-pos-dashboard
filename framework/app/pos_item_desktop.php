<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pos_item_desktop extends Model
{
    //
    protected $fillable = [
        'id_item',
        'nama_item',
        'hpp',
        'harga',
        'isDell',
    ];
}
