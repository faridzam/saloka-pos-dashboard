<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\pos_activity_item_and_desktop;
use Carbon\Carbon;

class OmsetHarian extends Component
{
    public function render()
    {

        $omsetHari = pos_activity_item_and_desktop::select('menu_store', 'isDell', 'created_at', 'total')
        ->whereNotIn('isDell', [1])
        ->whereNotIn('menu_store', [20])
        ->whereDate('created_at', Carbon::today())
        ->sum('total');

        return view('livewire.omset-harian', [
            'omsetHari' => $omsetHari,
        ]);
    }
}
