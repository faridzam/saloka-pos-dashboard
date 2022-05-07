<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\pos_activity_item_and_desktop;
use App\pos_store_desktop;
use Carbon\Carbon;

class OmsetHarian extends Component
{

    public $types;
    public $omset;
    public $stores;
    public $storeRevenue;

    protected $listeners = ['cekOmbak' => '$refresh'];

    public function mount(){
        $this->types = 0;
        $this->omset = 0;
        $this->stores = pos_store_desktop::where('id_store', '<', 1000)->get();

        $this->storeRevenue = pos_activity_item_and_desktop::groupBy('menu_store')
        ->whereNotIn('isDell', [1])
        ->whereNotIn('menu_store', [20])
        ->whereDate('created_at', Carbon::today())
        ->selectRaw('sum(total) as total_revenue, menu_store')
        ->orderBy('total_revenue', 'desc')
        ->get('total_revenue', 'menu_store');

    }

    public function cekOmbak()
    {

        if ($this->types == "0") {

            $this->omset = pos_activity_item_and_desktop::select('menu_store', 'isDell', 'created_at', 'total')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

            $this->storeRevenue = pos_activity_item_and_desktop::groupBy('menu_store')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->whereDate('created_at', Carbon::today())
            ->selectRaw('sum(total) as total_revenue, menu_store')
            ->orderBy('total_revenue', 'desc')
            ->get('total_revenue', 'menu_store');


        } elseif ($this->types == "1") {

            $dateS = Carbon::now();
            $dateE = Carbon::now()->subDays(7);
            $this->omset = pos_activity_item_and_desktop::select('menu_store', 'isDell', 'created_at', 'total')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', $dateE)
            ->sum('total');

            $this->storeRevenue = pos_activity_item_and_desktop::groupBy('menu_store')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', $dateE)
            ->selectRaw('sum(total) as total_revenue, menu_store')
            ->orderBy('total_revenue', 'desc')
            ->get('total_revenue', 'menu_store');

        } elseif ($this->types == "2") {

            $dateS = Carbon::now();
            $dateE = Carbon::now()->subMonth(1);
            $this->omset = pos_activity_item_and_desktop::select('menu_store', 'isDell', 'created_at', 'total')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', $dateE)
            ->sum('total');

            $this->storeRevenue = pos_activity_item_and_desktop::groupBy('menu_store')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', $dateE)
            ->selectRaw('sum(total) as total_revenue, menu_store')
            ->orderBy('total_revenue', 'desc')
            ->get('total_revenue', 'menu_store');

        } elseif ($this->types == "3") {

            $this->omset = pos_activity_item_and_desktop::select('menu_store', 'isDell', 'created_at', 'total')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');

            $this->storeRevenue = pos_activity_item_and_desktop::groupBy('menu_store')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw('sum(total) as total_revenue, menu_store')
            ->orderBy('total_revenue', 'desc')
            ->get('total_revenue', 'menu_store');

        } elseif ($this->types == "4") {

            $this->omset = pos_activity_item_and_desktop::select('menu_store', 'isDell', 'created_at', 'total')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->sum('total');

            $this->storeRevenue = pos_activity_item_and_desktop::groupBy('menu_store')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->selectRaw('sum(total) as total_revenue, menu_store')
            ->orderBy('total_revenue', 'desc')
            ->get('total_revenue', 'menu_store');

        }

    }

    public function render(){

        $this->stores = pos_store_desktop::where('id_store', '<', 1000)->get();

        if ($this->types == "0") {

            $this->omset = pos_activity_item_and_desktop::select('menu_store', 'isDell', 'created_at', 'total')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

            $this->storeRevenue = pos_activity_item_and_desktop::groupBy('menu_store')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->whereDate('created_at', Carbon::today())
            ->selectRaw('sum(total) as total_revenue, menu_store')
            ->orderBy('total_revenue', 'desc')
            ->get('total_revenue', 'menu_store');


        } elseif ($this->types == "1") {

            $dateS = Carbon::now();
            $dateE = Carbon::now()->subDays(7);
            $this->omset = pos_activity_item_and_desktop::select('menu_store', 'isDell', 'created_at', 'total')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', $dateE)
            ->sum('total');

            $this->storeRevenue = pos_activity_item_and_desktop::groupBy('menu_store')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', $dateE)
            ->selectRaw('sum(total) as total_revenue, menu_store')
            ->orderBy('total_revenue', 'desc')
            ->get('total_revenue', 'menu_store');

        } elseif ($this->types == "2") {

            $dateS = Carbon::now();
            $dateE = Carbon::now()->subMonth(1);
            $this->omset = pos_activity_item_and_desktop::select('menu_store', 'isDell', 'created_at', 'total')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', $dateE)
            ->sum('total');

            $this->storeRevenue = pos_activity_item_and_desktop::groupBy('menu_store')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', $dateE)
            ->selectRaw('sum(total) as total_revenue, menu_store')
            ->orderBy('total_revenue', 'desc')
            ->get('total_revenue', 'menu_store');

        } elseif ($this->types == "3") {

            $this->omset = pos_activity_item_and_desktop::select('menu_store', 'isDell', 'created_at', 'total')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');

            $this->storeRevenue = pos_activity_item_and_desktop::groupBy('menu_store')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw('sum(total) as total_revenue, menu_store')
            ->orderBy('total_revenue', 'desc')
            ->get('total_revenue', 'menu_store');

        } elseif ($this->types == "4") {

            $this->omset = pos_activity_item_and_desktop::select('menu_store', 'isDell', 'created_at', 'total')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->sum('total');

            $this->storeRevenue = pos_activity_item_and_desktop::groupBy('menu_store')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->selectRaw('sum(total) as total_revenue, menu_store')
            ->orderBy('total_revenue', 'desc')
            ->get('total_revenue', 'menu_store');

        }

        return view('livewire.omset-harian', [
            'omset' => $this->omset,
            'storeRevenue' => $this->storeRevenue,
            'stores' => $this->stores
        ]);

    }

}
