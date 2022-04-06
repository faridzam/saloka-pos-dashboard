<?php

namespace App\Http\Livewire;

use App\pos_kasir_desktop;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class KasirTable extends LivewireDatatable
{
    public $model = pos_kasir_desktop::class;

    public function columns()
    {
        //
    }
}
