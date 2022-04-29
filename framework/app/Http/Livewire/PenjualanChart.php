<?php

namespace App\Http\Livewire;

use App\pos_activity_item_and_desktop;
use App\pos_store_desktop;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\RadarChartModel;
use Asantibanez\LivewireCharts\Models\TreeMapChartModel;
use Carbon\Carbon;
use Livewire\Component;

class PenjualanChart extends Component
{
    public $types = ['12', '16', '3', '9', '10'];

    public $colors = [
        '12' => '#f6ad55',
        '16' => '#fc8181',
        '3' => '#90cdf4',
        '9' => '#66DA26',
        '10' => '#cbd5e0',
    ];

    public $firstRun = true;

    public $showDataLabels = false;

    protected $listeners = [
        'onPointClick' => 'handleOnPointClick',
        'onSliceClick' => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
        'onBlockClick' => 'handleOnBlockClick',
    ];

    public function handleOnPointClick($point)
    {
        dd($point);
    }

    public function handleOnSliceClick($slice)
    {
        dd($slice);
    }

    public function handleOnColumnClick($column)
    {
        dd($column);
    }

    public function handleOnBlockClick($block)
    {
        dd($block);
    }

    public function render()
    {

        $datas = pos_activity_item_and_desktop::select('id', 'menu_store', 'total', 'created_at')
        ->whereIn('menu_store', $this->types)
        ->get();

        $dateS = Carbon::now()->startOfMonth()->subMonth(5);
        $dateE = Carbon::now()->startOfMonth();


        // $columnChartModel = $datas->groupBy('menu_store')
        //     ->reduce(function ($columnChartModel, $data) {
        //         $type = $data->first()->menu_store;
        //         $value = $data->sum('total');

        //         return $columnChartModel->addColumn($type, $value, $this->colors[$type]);
        //     }, LivewireCharts::columnChartModel()
        //         ->setTitle('Expenses by Type')
        //         ->setAnimated($this->firstRun)
        //         ->withOnColumnClickEventName('onColumnClick')
        //         ->setLegendVisibility(false)
        //         ->setDataLabelsEnabled($this->showDataLabels)
        //         //->setOpacity(0.25)
        //         ->setColors(['#b01a1b', '#d41b2c', '#ec3c3b', '#f66665'])
        //         ->setColumnWidth(50)
        //         ->withGrid()
        // );

        // $lineChartModel = $datas
        //     ->reduce(function ($lineChartModel, $data) use ($datas) {

        //         $totalMonth = 12;
        //         $monthName = [];
        //         $monthNumber = [];
        //         for ($i=$totalMonth; $i >= 0; $i--) {
        //             $date = Carbon::now()->subMonth($i);
        //             $monthName[$i] = $date->format('F');
        //             $monthNumber[$i] = $date->month();
        //         }

        //         $index = $datas->search($data);
        //         $amountSum = $datas->take($index + 1)->sum('total');

        //         return $lineChartModel->addPoint($index, $amountSum, ['total' => $data->total]);
        //     }, LivewireCharts::lineChartModel()
        //         //->setTitle('Expenses Evolution')
        //         ->setAnimated($this->firstRun)
        //         ->withOnPointClickEvent('onPointClick')
        //         ->setSmoothCurve()
        //         ->setXAxisVisible(true)
        //         ->setDataLabelsEnabled($this->showDataLabels)
        //         ->sparklined()
        //     );

        // $multiLineChartModel = $datas
        //     ->reduce(function ($multiLineChartModel, $data) use ($datas) {

        //         return $multiLineChartModel
        //             ->addSeriesPoint($data->menu_store, date('F', $data->created_at->format('m')), $data->total);
        //     }, LivewireCharts::multiLineChartModel()
        //         //->setTitle('Expenses by Type')
        //         ->setAnimated($this->firstRun)
        //         ->withOnPointClickEvent('onPointClick')
        //         ->setSmoothCurve()
        //         ->multiLine()
        //         ->setDataLabelsEnabled($this->showDataLabels)
        //         ->sparklined()
        //         ->setColors(['#b01a1b', '#d41b2c', '#ec3c3b', '#f66665'])
        //     );

        $multiLineChartModel = LivewireCharts::multiLineChartModel()
            ->setTitle('Stores Income')
            ->setAnimated($this->firstRun)
            ->setSmoothCurve()
            ->multiLine()
            ->setDataLabelsEnabled($this->showDataLabels)
            //->setColors(['#169870', '#F39F19', '#0b4c38', '#0b4c38', '#107254', '#b67713', '#45ad8d', '#f5b247', '#73c1a9', '#f8c575', '#bf9860', '#f1241b', '#1e56af', '#604c30', '#79120e', '#0f2b58', '#8f7248', '#b51b14', '#164183', '#ccad80', '#f45049', '#4b78bf', '#d9c1a0', '#f77c76', '#789acf'])
            ->addSeriesPoint('VW Long', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 1)->sum('total'))
            ->addSeriesPoint('VW Long', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 1)->sum('total'))
            ->addSeriesPoint('VW Long', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 1)->sum('total'))
            ->addSeriesPoint('VW Long', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 1)->sum('total'))
            ->addSeriesPoint('VW Long', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 1)->sum('total'))
            ->addSeriesPoint('VW Long', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 1)->sum('total'))
            ->addSeriesPoint('Bazar Taman', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 2)->sum('total'))
            ->addSeriesPoint('Bazar Taman', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 2)->sum('total'))
            ->addSeriesPoint('Bazar Taman', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 2)->sum('total'))
            ->addSeriesPoint('Bazar Taman', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 2)->sum('total'))
            ->addSeriesPoint('Bazar Taman', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 2)->sum('total'))
            ->addSeriesPoint('Bazar Taman', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 2)->sum('total'))
            ->addSeriesPoint('Ararya', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 3)->sum('total'))
            ->addSeriesPoint('Ararya', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 3)->sum('total'))
            ->addSeriesPoint('Ararya', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 3)->sum('total'))
            ->addSeriesPoint('Ararya', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 3)->sum('total'))
            ->addSeriesPoint('Ararya', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 3)->sum('total'))
            ->addSeriesPoint('Ararya', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 3)->sum('total'))
            ->addSeriesPoint('AT Retail', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 4)->sum('total'))
            ->addSeriesPoint('AT Retail', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 4)->sum('total'))
            ->addSeriesPoint('AT Retail', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 4)->sum('total'))
            ->addSeriesPoint('AT Retail', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 4)->sum('total'))
            ->addSeriesPoint('AT Retail', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 4)->sum('total'))
            ->addSeriesPoint('AT Retail', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 4)->sum('total'))
            ->addSeriesPoint('Daimami', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 5)->sum('total'))
            ->addSeriesPoint('Daimami', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 5)->sum('total'))
            ->addSeriesPoint('Daimami', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 5)->sum('total'))
            ->addSeriesPoint('Daimami', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 5)->sum('total'))
            ->addSeriesPoint('Daimami', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 5)->sum('total'))
            ->addSeriesPoint('Daimami', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 5)->sum('total'))
            ->addSeriesPoint('Red Truck', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 6)->sum('total'))
            ->addSeriesPoint('Red Truck', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 6)->sum('total'))
            ->addSeriesPoint('Red Truck', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 6)->sum('total'))
            ->addSeriesPoint('Red Truck', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 6)->sum('total'))
            ->addSeriesPoint('Red Truck', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 6)->sum('total'))
            ->addSeriesPoint('Red Truck', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 6)->sum('total'))
            ->addSeriesPoint('Polah Bocah', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 7)->sum('total'))
            ->addSeriesPoint('Polah Bocah', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 7)->sum('total'))
            ->addSeriesPoint('Polah Bocah', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 7)->sum('total'))
            ->addSeriesPoint('Polah Bocah', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 7)->sum('total'))
            ->addSeriesPoint('Polah Bocah', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 7)->sum('total'))
            ->addSeriesPoint('Polah Bocah', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 7)->sum('total'))
            ->addSeriesPoint('Segara Prada', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 8)->sum('total'))
            ->addSeriesPoint('Segara Prada', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 8)->sum('total'))
            ->addSeriesPoint('Segara Prada', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 8)->sum('total'))
            ->addSeriesPoint('Segara Prada', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 8)->sum('total'))
            ->addSeriesPoint('Segara Prada', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 8)->sum('total'))
            ->addSeriesPoint('Segara Prada', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 8)->sum('total'))
            ->addSeriesPoint('Kedai AT', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 9)->sum('total'))
            ->addSeriesPoint('Kedai AT', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 9)->sum('total'))
            ->addSeriesPoint('Kedai AT', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 9)->sum('total'))
            ->addSeriesPoint('Kedai AT', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 9)->sum('total'))
            ->addSeriesPoint('Kedai AT', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 9)->sum('total'))
            ->addSeriesPoint('Kedai AT', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 9)->sum('total'))
            ->addSeriesPoint('Shop 89', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 10)->sum('total'))
            ->addSeriesPoint('Shop 89', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 10)->sum('total'))
            ->addSeriesPoint('Shop 89', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 10)->sum('total'))
            ->addSeriesPoint('Shop 89', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 10)->sum('total'))
            ->addSeriesPoint('Shop 89', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 10)->sum('total'))
            ->addSeriesPoint('Shop 89', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 10)->sum('total'))
            ->addSeriesPoint('Rimba Cafe', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 12)->sum('total'))
            ->addSeriesPoint('Rimba Cafe', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 12)->sum('total'))
            ->addSeriesPoint('Rimba Cafe', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 12)->sum('total'))
            ->addSeriesPoint('Rimba Cafe', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 12)->sum('total'))
            ->addSeriesPoint('Rimba Cafe', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 12)->sum('total'))
            ->addSeriesPoint('Rimba Cafe', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 12)->sum('total'))
            ->addSeriesPoint('Jenju', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 16)->sum('total'))
            ->addSeriesPoint('Jenju', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 16)->sum('total'))
            ->addSeriesPoint('Jenju', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 16)->sum('total'))
            ->addSeriesPoint('Jenju', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 16)->sum('total'))
            ->addSeriesPoint('Jenju', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 16)->sum('total'))
            ->addSeriesPoint('Jenju', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 16)->sum('total'))
            ->addSeriesPoint('Shop 04', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 17)->sum('total'))
            ->addSeriesPoint('Shop 04', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 17)->sum('total'))
            ->addSeriesPoint('Shop 04', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 17)->sum('total'))
            ->addSeriesPoint('Shop 04', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 17)->sum('total'))
            ->addSeriesPoint('Shop 04', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 17)->sum('total'))
            ->addSeriesPoint('Shop 04', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 17)->sum('total'))
            ->addSeriesPoint('Shop 03', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 18)->sum('total'))
            ->addSeriesPoint('Shop 03', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 18)->sum('total'))
            ->addSeriesPoint('Shop 03', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 18)->sum('total'))
            ->addSeriesPoint('Shop 03', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 18)->sum('total'))
            ->addSeriesPoint('Shop 03', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 18)->sum('total'))
            ->addSeriesPoint('Shop 03', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 18)->sum('total'))
            ->addSeriesPoint('Cek IT', Carbon::now()->subMonth(5)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5)->format('m'))->where('menu_store', 20)->sum('total'))
            ->addSeriesPoint('Cek IT', Carbon::now()->subMonth(4)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(4)->format('m'))->where('menu_store', 20)->sum('total'))
            ->addSeriesPoint('Cek IT', Carbon::now()->subMonth(3)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(3)->format('m'))->where('menu_store', 20)->sum('total'))
            ->addSeriesPoint('Cek IT', Carbon::now()->subMonth(2)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(2)->format('m'))->where('menu_store', 20)->sum('total'))
            ->addSeriesPoint('Cek IT', Carbon::now()->subMonth(1)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(1)->format('m'))->where('menu_store', 20)->sum('total'))
            ->addSeriesPoint('Cek IT', Carbon::now()->subMonth(0)->format('F'), pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(0)->format('m'))->where('menu_store', 20)->sum('total'));

            $this->firstRun = false;

        return view('livewire.penjualan-chart')
            ->with([
                //'columnChartModel' => $columnChartModel,
                // 'pieChartModel' => $pieChartModel,
                //'lineChartModel' => $lineChartModel,
                // 'areaChartModel' => $areaChartModel,
                'multiLineChartModel' => $multiLineChartModel,
                // 'multiColumnChartModel' => $multiColumnChartModel,
                // 'radarChartModel' => $radarChartModel,
                // 'treeChartModel' => $treeChartModel,
            ]);
    }
}
