<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pos_co_desktop extends Model
{
    //
    protected $fillable = [
        'kasir',
        'no_co',
        'deposit',
        'omset',
        'profit',
        'created_at',
        'updated_at',
    ];
}
