<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\pos_product_item_desktop;
use App\pos_activity_item_and_desktop;

class ItemSales extends Component
{

    public $itemSalesOption;
    public $items;
    public $storeItemSales;

    protected $listeners = ['changeItemSalesOption' => '$refresh'];

    public function mount(){

        $this->itemSalesOption = 0;
        $this->items = pos_product_item_desktop::all();

        $this->storeItemSales = pos_activity_item_and_desktop::groupBy('id_item')
        ->whereNotIn('isDell', [1])
        ->whereNotIn('menu_store', [20])
        ->whereDate('created_at', Carbon::today())
        ->selectRaw('sum(qty) as total_quantities, id_item')
        ->orderBy('total_quantities', 'desc')
        ->limit(10)
        ->get('total_quantities', 'id_item');

    }

    public function changeItemSalesOption()
    {

        if ($this->itemSalesOption == "0") {

            $this->storeItemSales = pos_activity_item_and_desktop::groupBy('id_item')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->whereDate('created_at', Carbon::today())
            ->selectRaw('sum(qty) as total_quantities, id_item')
            ->orderBy('total_quantities', 'desc')
            ->limit(10)
            ->get('total_quantities', 'id_item');

        } elseif ($this->itemSalesOption == "1") {

            $dateE = Carbon::now()->subDays(7);
            $this->storeItemSales = pos_activity_item_and_desktop::groupBy('id_item')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', $dateE)
            ->selectRaw('sum(qty) as total_quantities, id_item')
            ->orderBy('total_quantities', 'desc')
            ->limit(10)
            ->get('total_quantities', 'id_item');

        } elseif ($this->itemSalesOption == "2") {

            $dateE = Carbon::now()->subMonth(1);
            $this->storeItemSales = pos_activity_item_and_desktop::groupBy('id_item')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', $dateE)
            ->selectRaw('sum(qty) as total_quantities, id_item')
            ->orderBy('total_quantities', 'desc')
            ->limit(10)
            ->get('total_quantities', 'id_item');

        } elseif ($this->itemSalesOption == "3") {

            $this->storeItemSales = pos_activity_item_and_desktop::groupBy('id_item')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw('sum(qty) as total_quantities, id_item')
            ->orderBy('total_quantities', 'desc')
            ->limit(10)
            ->get('total_quantities', 'id_item');

        } elseif ($this->itemSalesOption == "4") {

            $this->storeItemSales = pos_activity_item_and_desktop::groupBy('id_item')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->selectRaw('sum(qty) as total_quantities, id_item')
            ->orderBy('total_quantities', 'desc')
            ->limit(10)
            ->get('total_quantities', 'id_item');

        }

    }

    public function render()
    {

        $this->items = pos_product_item_desktop::all();

        if ($this->itemSalesOption == "0") {

            $this->storeItemSales = pos_activity_item_and_desktop::groupBy('id_item')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->whereDate('created_at', Carbon::today())
            ->selectRaw('sum(qty) as total_quantities, id_item')
            ->orderBy('total_quantities', 'desc')
            ->limit(10)
            ->get('total_quantities', 'id_item');

        } elseif ($this->itemSalesOption == "1") {

            $dateE = Carbon::now()->subDays(7);
            $this->storeItemSales = pos_activity_item_and_desktop::groupBy('id_item')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', $dateE)
            ->selectRaw('sum(qty) as total_quantities, id_item')
            ->orderBy('total_quantities', 'desc')
            ->limit(10)
            ->get('total_quantities', 'id_item');

        } elseif ($this->itemSalesOption == "2") {

            $dateE = Carbon::now()->subMonth(1);
            $this->storeItemSales = pos_activity_item_and_desktop::groupBy('id_item')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', $dateE)
            ->selectRaw('sum(qty) as total_quantities, id_item')
            ->orderBy('total_quantities', 'desc')
            ->limit(10)
            ->get('total_quantities', 'id_item');

        } elseif ($this->itemSalesOption == "3") {

            $this->storeItemSales = pos_activity_item_and_desktop::groupBy('id_item')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw('sum(qty) as total_quantities, id_item')
            ->orderBy('total_quantities', 'desc')
            ->limit(10)
            ->get('total_quantities', 'id_item');

        } elseif ($this->itemSalesOption == "4") {

            $this->storeItemSales = pos_activity_item_and_desktop::groupBy('id_item')
            ->whereNotIn('isDell', [1])
            ->whereNotIn('menu_store', [20])
            ->selectRaw('sum(qty) as total_quantities, id_item')
            ->orderBy('total_quantities', 'desc')
            ->limit(10)
            ->get('total_quantities', 'id_item');

        }

        return view('livewire.item-sales', [
            'storeItemSales' => $this->storeItemSales,
            'items' => $this->items,
        ]);
    }
}
