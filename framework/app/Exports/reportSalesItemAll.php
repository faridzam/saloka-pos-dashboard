<?php

namespace App\Exports;

use App\pos_activity_item_and_desktop;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class reportSalesItemAll implements FromCollection,WithHeadings,WithStyles,WithColumnWidths,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $conditions = array();

    public function __construct(array $conditions)
    {
        $this->conditions = $conditions;
    }

    public function collection()
    {
        //return pos_activity_item_and_desktop::query()->where('id_store', $this->store)->whereBetween('created_at', [$this->from." 00:00:00", $this->to." 23:59:59"]);
        $con = $this->conditions;
        $from = $con['from'];
        $to = $con['to'];
        $store = $con['store'];

        $data1 = pos_activity_item_and_desktop::select('id_item')
        ->groupBy('id_item')
        ->where('isDell', 0)
        ->whereBetween('created_at', [$from, $to])
        ->orderBy('nama_item', 'asc')
        ->get();

        $data = collect([]);
        $totalQuantity = 0;

        foreach ($data1 as $value) {
            $id_item = $value->id_item;
            $nama_item = pos_activity_item_and_desktop::where('id_item', $value->id_item)->first()->nama_item;
            $quantity = pos_activity_item_and_desktop::where('id_item', $value->id_item)
            ->where('isDell', 0)
            ->whereBetween('created_at', [$from, $to])
            ->sum('qty');
            $total = pos_activity_item_and_desktop::where('id_item', $value->id_item)
            ->where('isDell', 0)
            ->whereBetween('created_at', [$from, $to])
            ->sum('total');

            $data->push(['id_item'=>$id_item, 'nama_item'=>$nama_item, 'qty'=>$quantity, 'total'=>$total]);
        }

        return $data;
    }

    public function headings(): array
    {
        $con = $this->conditions;
        $user = $con['user'];
        $store = $con['store'];
        $totalProfit = $con['totalProfit'];
        $totalOmset = $con['totalOmset'];

        return [["Nama Store:", $store],
        ["User:", $user],
        ["Total Profit:", $totalProfit],
        ["Total Omset:", $totalOmset],
        [""],
        [""],
        ["ID Item", "Nama Item", "Quantity", "Total"]];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            7    => ['font' => ['bold' => true]],
        ];
    }


    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 30,
            'C' => 10,
            'D' => 15,
            'E' => 15,
            'F' => 20,
            'G' => 20,
        ];
    }

    // public function columnFormats(): array
    // {
    //     return [
    //         'D' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
    //         'E' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
    //         'F' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
    //         'G' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
    //         'B3' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
    //     ];
    // }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:Z1048576')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            },
        ];
    }

}
