<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\pos_store_desktop;
use Illuminate\Http\Request;
use App\pos_activity_and_desktop;
use Illuminate\Support\Facades\Auth;
use App\pos_activity_item_and_desktop;
use App\Exports\exportLaporanPenjualan;
use Maatwebsite\Excel\Facades\Excel;

class laporanPenjualan extends Controller
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

        return view('app.laporanPenjualan', compact('user', 'stores', 'dateNow'));
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

        $dataTable = pos_activity_and_desktop::whereIn('no_invoice', $dataQuery)->get();
        $totalProfit = pos_activity_item_and_desktop::whereIn('no_invoice', $dataQuery)->sum('profit');
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
       foreach($dataTable as $row)
       {
        $output .= '
        <tr data-id="'. $row->no_invoice.'">
         <th style="width: 20%;" scope="row">'.$row->no_invoice.'</th>
         <td style="width: 10%;" >'.$row->id_kasir.'</td>
         <td style="width: 20%;" >'.$row->metode.'</td>
         <td style="width: 20%;" >'."Rp. ".number_format($row->total_pembelian,0,",",".").'</td>
         <td style="width: 15%;" >'.date('d-m-Y', strtotime($row->created_at)).'</td>
         <td style="width: 15%;" >'.date('H:i:s', strtotime($row->created_at)).'</td>
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
        $datas = pos_activity_item_and_desktop::where('no_invoice', $invoices)->get();
        $user  = Auth::user()->name;

        $totalProfit = pos_activity_item_and_desktop::whereIn('no_invoice', $invoices)->sum('profit');
        $totalOmset = pos_activity_item_and_desktop::whereIn('no_invoice', $invoices)->sum('total');
        
        $conditions = array(
            'store' => $request->id_store,
            'user' => Auth::user()->name,
            'from' => $from,
            'to' => $to,
            'totalProfit' => $totalProfit,
            'totalOmset' => $totalOmset,
        );

        $export = new exportLaporanPenjualan($conditions);

        return Excel::download($export, 'report-'.$store.'.xlsx');
    }
}
