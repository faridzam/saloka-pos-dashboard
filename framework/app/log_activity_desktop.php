<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log_activity_desktop extends Model
{
    //
    protected $fillable = [
        'pic',
        'tipe',
        'keterangan',
    ];
}
