<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pos_kategori_desktop extends Model
{
    //
    protected $fillable = [
        'id_kategori',
        'nama_kategori',
        'isDell',
    ];
}
