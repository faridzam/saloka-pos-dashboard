<?php

namespace App\Exports;

use App\pos_activity_item_and_desktop;
use App\void_log_desktop;

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

class exportLaporanPenjualan implements FromCollection,WithHeadings,WithStyles,WithColumnWidths,WithEvents//,WithColumnFormatting
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

        $data1 = pos_activity_item_and_desktop::select('no_invoice', 'nama_item', 'qty', 'hpp', 'harga', 'total', 'profit')
        ->where('id_store', $store)
        ->whereBetween('created_at', [$from, $to])
        ->get();
        
        $data2 = void_log_desktop::select('no_invoice', 'kasir', 'pic', 'id_store', 'keterangan')
        ->where('id_store', $store)
        ->whereBetween('created_at', [$from, $to])
        ->get();
        

        return $data1;
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
        ["Nomor Invoice", "Nama Item", "Quantity", "Hpp", "harga", "total", "profit"]];
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
