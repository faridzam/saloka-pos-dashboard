<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pos_stock_desktop extends Model
{
    //
    
    protected $fillable = [
        'id_item',
        'nama_item',
        'qty',
        'min_qty',
    ];
}
