<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\pos_activity_item_and_desktop;

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

    public function itemSales()
    {
        return $this->hasMany(pos_activity_item_and_desktop::class, 'menu_store', 'menu_store');
    }

}
