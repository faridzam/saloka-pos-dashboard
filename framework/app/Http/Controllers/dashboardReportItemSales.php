<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\pos_store_desktop;
use App\log_activity_desktop;
use Illuminate\Http\Request;
use App\pos_activity_and_desktop;
use Illuminate\Support\Facades\Auth;
use App\pos_activity_item_and_desktop;
use App\Exports\reportSalesItem;
use Maatwebsite\Excel\Facades\Excel;

class dashboardReportItemSales extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user  = Auth::user()->name;
        $stores = pos_store_desktop::all();
        $dateNow = Carbon::now()->format('Y-m-d');

        return view('app.reportItemSales', compact('user', 'stores', 'dateNow'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function search(Request $request)
    {

     if($request->ajax())
     {
      $output = '';
      $store = $request->get('id_store');
      $dateStart = $request->get('tanggalAwal');
      $dateEnd = $request->get('tanggalAkhir');

      if($store != '-- Silahkan Pilih Store --')
      {
        $dataQuery = pos_activity_and_desktop::where('id_store', $store)
        ->whereBetween('created_at', [$dateStart." 00:00:00", $dateEnd." 23:59:59"])
        ->orderBy('created_at', 'desc')
        ->pluck('no_invoice');

        $dataTable = pos_activity_item_and_desktop::distinct()
        ->whereIn('no_invoice', $dataQuery)
        ->where('isDell', 0)
        ->get('id_item', 'nama_item', 'harga', 'qty', 'total', 'created_at');
        
        $totalProfit = pos_activity_item_and_desktop::whereIn('no_invoice', $dataQuery)
        ->where('isDell', 0)
        ->sum('total');
        
        $data = collect([]);

        foreach ($dataTable as $value) {
            $id_item = $value->id_item;
            $nama_item = pos_activity_item_and_desktop::where('id_item', $value->id_item)
            ->where('isDell', 0)
            ->where('id_store', $store)
            ->value('nama_item');
            $harga = pos_activity_item_and_desktop::where('id_item', $value->id_item)
            ->where('isDell', 0)
            ->where('id_store', $store)
            ->value('harga');
            $quantity = pos_activity_item_and_desktop::where('id_item', $value->id_item)
            ->where('isDell', 0)
            ->where('id_store', $store)
            ->whereBetween('created_at', [$dateStart." 00:00:00", $dateEnd." 23:59:59"])
            ->sum('qty');
            $total = pos_activity_item_and_desktop::where('id_item', $value->id_item)
            ->where('isDell', 0)
            ->where('id_store', $store)
            ->whereBetween('created_at', [$dateStart." 00:00:00", $dateEnd." 23:59:59"])
            ->sum('total');
            
            $data->push(['id_item'=>$id_item, 'nama_item'=>$nama_item, 'harga'=>$harga, 'qty'=>$quantity, 'total'=>$total]);
        }
        
      }
      else
      {
        $output = '
        <tr>
            <td align="center" colspan="5">Store Belum Dipilih</td>
        </tr>
        ';
      }

      $token = $request->session()->token();

      $total_row = $dataTable->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr data-id="'.$row['id_item'].'">
         <th style="width: 15%;" scope="row" >'.$row['id_item'].'</th>
         <td style="width: 20%;" >'.$row['nama_item'].'</td>
         <td style="width: 15%;" >'."Rp. ".number_format($row['harga'],0,",",".").'</td>
         <td style="width: 10%;" >'.$row['qty'].'</td>
         <td style="width: 15%;" >'."Rp. ".number_format($row['total'],0,",",".").'</td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row,
       'profit' => "Rp. ".number_format($totalProfit,0,",","."),
      );

      echo json_encode($data);
     }
    }
    
    public function exportLaporanPenjualan(Request $request)
    {

        $store = pos_store_desktop::where('id_store', $request->id_store)->value('nama_store');
        $from = $request->tanggalAwal." 00:00:00";
        $to = $request->tanggalAkhir." 23:59:59";
        $invoices = pos_activity_and_desktop::where('id_store', $request->id_store)
        ->whereBetween('created_at', [$from." 00:00:00", $to." 23:59:59"])
        ->pluck('no_invoice')
        ->toArray();
        $datas = pos_activity_item_and_desktop::where('no_invoice', $invoices)
        ->where('isDell', 0)
        ->get();
        $user  = Auth::user()->name;
        
        log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 1,
            'keterangan' => Auth::user()->name." Telah Mengambil Laporan Penjualan :"."\nstore : ".$store."\ndari tanggal : ".$from."\nhingga tanggal : ".$to,
        ]);

        $totalProfit = pos_activity_item_and_desktop::whereIn('no_invoice', $invoices)
        ->where('isDell', 0)
        ->sum('profit');
        $totalOmset = pos_activity_item_and_desktop::whereIn('no_invoice', $invoices)
        ->where('isDell', 0)
        ->sum('total');
        
        $conditions = array(
            'store' => $request->id_store,
            'user' => Auth::user()->name,
            'from' => $from,
            'to' => $to,
            'totalProfit' => $totalProfit,
            'totalOmset' => $totalOmset,
        );

        $export = new reportSalesItem($conditions);

        return Excel::download($export, 'report-'.$store.'.xlsx');
    }
}
