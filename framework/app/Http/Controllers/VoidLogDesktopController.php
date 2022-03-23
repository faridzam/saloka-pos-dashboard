<?php

namespace App\Http\Controllers;

use App\void_log_desktop;
use App\pos_kasir_desktop;
use App\pos_store_desktop;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\pos_activity_item_and_desktop;
use App\pos_activity_and_desktop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class VoidLogDesktopController extends Controller
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
        $stores = pos_store_desktop::select('menu_store', 'nama_store')
        ->distinct()
        ->get();
        $dateNow = Carbon::now()->format('Y-m-d');

        return view('app.voidTransaksi', compact('user', 'stores', 'dateNow'));
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
     * @param  \App\void_log_desktop  $void_log_desktop
     * @return \Illuminate\Http\Response
     */
    public function show(void_log_desktop $void_log_desktop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\void_log_desktop  $void_log_desktop
     * @return \Illuminate\Http\Response
     */
    public function edit(void_log_desktop $void_log_desktop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\void_log_desktop  $void_log_desktop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, void_log_desktop $void_log_desktop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\void_log_desktop  $void_log_desktop
     * @return \Illuminate\Http\Response
     */
    public function destroy(void_log_desktop $void_log_desktop)
    {
        //
    }

    public function search(Request $request)
    {

     if($request->ajax())
     {
      $output = '';
      $outputVoid = '';
      $store = $request->get('id_store');
      $storeName = pos_store_desktop::where('id_store', $store)->value('nama_store');
      $dateStart = $request->get('tanggalAwal');
      $dateEnd = $request->get('tanggalAkhir');

      if($store != '-- Silahkan Pilih Store --')
      {
        $dataQuery = pos_activity_and_desktop::where('menu_store', $store)
        ->whereBetween('created_at', [$dateStart." 00:00:00", $dateEnd." 23:59:59"])
        ->orderBy('created_at', 'desc')
        ->pluck('no_invoice');

        $dataTable = pos_activity_and_desktop::whereIn('no_invoice', $dataQuery)->get();

        $voidTable = void_log_desktop::where('id_store', $store)
        ->whereBetween('created_at', [$dateStart." 00:00:00", $dateEnd." 23:59:59"])
        ->get();

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
        $namaKasir = pos_kasir_desktop::where('id', $row->id_kasir)->value('name');
        $voidButton = '<a class="btn bg-danger btn-primary border-0 voidRequest" data-toggle="modal" data-target="#invoiceGuard" data-id="'.$row->no_invoice.'" value="'.$row->no_invoice.'">void</a>';

        $output .= '
        <tr data-id="'. $row->no_invoice.'">
         <td style="width: 15%; font-weight: bold;" scope="row" data-value="'.$row->no_invoice.'">'.$row->no_invoice.'</td>
         <td style="width: 7%;" data-value="'.$namaKasir.'">'.$namaKasir.'</td>
         <td style="width: 15%;" data-value="'.$row->metode.'">'.$row->metode.'</td>
         <td style="width: 15%;" data-value="'.$row->total_pembelian.'">'."Rp. ".number_format($row->total_pembelian,0,",",".").'</td>
         <td style="width: 15%;" data-value="'.date('d-m-Y', strtotime($row->created_at)).'">'.date('d-m-Y', strtotime($row->created_at)).'</td>
         <td style="width: 15%;" data-value="'.date('H:i:s', strtotime($row->created_at)).'">'.date('H:i:s', strtotime($row->created_at)).'</td>
         <td style="width: 5%;" id="void-invoice">'.$voidButton.'</td>
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

      //voidTable
      $total_row_void = $voidTable->count();
      if($total_row_void > 0)
      {
       foreach($voidTable as $row)
       {
        $outputVoid .= '
        <tr data-id="'. $row->no_invoice.'">
         <td style="width: 20%; font-weight: bold;" scope="row" data-value="'.$row->no_invoice.'">'.$row->no_invoice.'</td>
         <td style="width: 10%;" data-value="'.$row->kasir.'">'.$row->kasir.'</td>
         <td style="width: 10%;" data-value="'.$row->pic.'">'.$row->pic.'</td>
         <td style="width: 10%;" data-value="'.$storeName.'">'.$storeName.'</td>
         <td style="width: 20%;" data-value="'.$row->keterangan.'">'.$row->keterangan.'</td>
         <td style="width: 15%;" data-value="'.date('d-m-Y', strtotime($row->created_at)).'">'.date('d-m-Y', strtotime($row->created_at)).'</td>
         <td style="width: 15%;" data-value="'.date('H:i:s', strtotime($row->created_at)).'">'.date('H:i:s', strtotime($row->created_at)).'</td>
        </tr>
        ';
       }
      }
      else
      {
       $outputVoid = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }


      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row,
       'table_void'  => $outputVoid,
      );

      echo json_encode($data);
     }
    }

    public function voidVerification(Request $request){

        $request->validate([
            'password' => 'required',
            'keterangan' => 'required'
        ]);

        $user = Auth::user();

        if(Hash::check($request->password, $user->password)){

            $kasirID = pos_activity_and_desktop::where('no_invoice', $request->no_invoice)
            ->value('id_kasir');
            $kasir = pos_kasir_desktop::where('id', $kasirID)
            ->value('name');

            $storeID = pos_activity_and_desktop::where('no_invoice', $request->no_invoice)
            ->value('id_store');
            $store = pos_store_desktop::where('id_store', $storeID)
            ->value('menu_store');

            void_log_desktop::create([
                'no_invoice' => $request->no_invoice,
                'kasir' => $kasir,
                'pic' => Auth::user()->name,
                'id_store' => $store,
                'keterangan' => $request->keterangan,
            ]);

            pos_activity_and_desktop::where('no_invoice', $request->no_invoice)
            ->delete();

            $invoices = pos_activity_item_and_desktop::where('no_invoice', $request->no_invoice)->get();
            foreach ($invoices as $data){

                $data->isDell = 1;
                $data->save();

            }

            return redirect()->intended('dashboardVoidTransaksi')->with('success', 'login void sukses');
        }

        return back()->with('failed', 'login void gagal');

    }

    public function voidInvoice(Request $request, $no_invoice){
        //

        $kasirID = pos_activity_and_desktop::where('no_invoice', $no_invoice)
        ->value('id_kasir');
        $kasir = pos_kasir_desktop::where('id', $kasirID)
        ->value('name');

        $storeID = pos_activity_and_desktop::where('no_invoice', $no_invoice)
        ->value('id_store');
        $store = pos_store_desktop::where('id_store', $storeID)
        ->value('menu_store');

        void_log_desktop::create([
            'no_invoice' => $no_invoice,
            'kasir' => $kasir,
            'pic' => Auth::user()->name,
            'id_store' => $store,
        ]);

        pos_activity_and_desktop::where('no_invoice', $no_invoice)
        ->delete();
        pos_activity_item_and_desktop::where('no_invoice', $no_invoice)
        ->delete();


        return redirect('dashboardVoidTransaksi');
    }

}
