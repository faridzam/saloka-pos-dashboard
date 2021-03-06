<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pos_store_desktop;
use App\pos_stock_desktop;
use App\pos_product_item_desktop;
use App\pos_product_kategori_desktop;
use App\log_activity_desktop;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class stockManagement extends Controller
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

        return view('app.stockManagement', compact('user', 'stores', 'dateNow'));
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

        log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 2,
            'keterangan' => Auth::user()->name." Telah Menambahkan Stok Produk:"."\nid item : ".$request->id_item."\nnama item : ".$request->nama_item."\nqty : ".$request->qty,
        ]);

        $request->validate([
            'id_store' => 'required',
            'id_item' => 'required',
            'nama_item' => 'required',
            'qty' => 'required',
            'min_qty' => 'required',
        ]);

        pos_stock_desktop::insertGetId([
            'id_store' => $request->id_store,
            'id_item' => $request->id_item,
            'nama_item' => $request->nama_item,
            'qty' => $request->qty,
            'min_qty' => $request->min_qty,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect('dashboardStockManagement');

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
      $outputKategori = '<option value="*">'."ALL".'</option>';

      $store = $request->get('id_store');
      $cat = $request->get('id_kategori');

      if($store != '-- Silahkan Pilih Store --')
      {
        $dataQuery = pos_product_item_desktop::where('id_store', $store)
        ->pluck('id_item');

        $kategori = pos_product_kategori_desktop::where('id_store', $store)
        ->get();

        if($cat == '*'){
            $dataTables = pos_product_item_desktop::whereIn('id_item', $dataQuery)
            ->where('id_store', $store)
            ->orderBy('id_item', 'asc')
            ->pluck('id_item');
        } else {
            $dataTables = pos_product_item_desktop::whereIn('id_item', $dataQuery)
            ->where('id_store', $store)
            ->where('id_kategori', $cat)
            ->orderBy('id_item', 'asc')
            ->pluck('id_item');
        }

        $dataTable = pos_stock_desktop::whereIn('id_item', $dataTables)
        ->where('id_store', $store)
        ->get();

        foreach ($kategori as $row){
            $outputKategori .= '<option value="'.$row->id_kategori.'">'.$row->nama_kategori.'</option>';
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

      $total_row = $dataTable->count();
      if($total_row > 0)
      {
       foreach($dataTable as $row)
       {
            $plusButton= '<a class="btn btn-primary btn-lg open-modal" data-toggle="modal" data-target="#plusStock" data-id="'.$row->id.'" data-item="'.$row->id_item.'" data-nama="'.$row->nama_item.'" data-qty="'.$row->qty.'" data-min_qty="'.$row->min_qty.'" value='.$row->id.'> <i class="fas fa-plus"></i> </a>';
            $removeButton= '<a class="btn btn-danger btn-lg open-modal-min" data-toggle="modal" data-target="#minStock" data-id="'.$row->id.'" data-item="'.$row->id_item.'" data-nama="'.$row->nama_item.'" data-qty="'.$row->qty.'" data-min_qty="'.$row->min_qty.'" value='.$row->id.'> <i class="fas fa-minus"></i></a>';

            if($row->qty < $row->min_qty){

                $output .= '
                <tr data-id="'. $row->id_item.'">
                    <td style="width: 10%; font-weight: bold; background-color: red; color: white;" scope="row" data-value="'.$row->id_item.'">'.$row->id_item.'</td>
                    <td style="width: 20%; background-color: red; color: white;" data-value="'.$row->nama_item.'">'.$row->nama_item.'</td>
                    <td style="width: 15%; background-color: red; color: white;" data-value="'.$row->qty.'">'.$row->qty.'</td>
                    <td style="width: 15%; background-color: red; color: white;" data-value="'.$row->min_qty.'">'.$row->min_qty.'</td>
                    <td style="width: 5%; background-color: red; color: white;" >'.$plusButton.'</td>
                    <td style="width: 5%; background-color: red; color: white;" >'.$removeButton.'</td>
                </tr>
                ';

            } else{

                $output .= '
                <tr data-id="'. $row->id_item.'">
                    <td style="width: 10%; font-weight: bold;" scope="row" data-value="'.$row->id_item.'">'.$row->id_item.'</td>
                    <td style="width: 20%;" data-value="'.$row->nama_item.'">'.$row->nama_item.'</td>
                    <td style="width: 15%;" data-value="'.$row->qty.'">'.$row->qty.'</td>
                    <td style="width: 15%;" data-value="'.$row->min_qty.'">'.$row->min_qty.'</td>
                    <td style="width: 5%;" >'.$plusButton.'</td>
                    <td style="width: 5%;" >'.$removeButton.'</td>
                </tr>
                ';

            }

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
       'kategori_data' => $outputKategori,
      );

      echo json_encode($data);
     }
    }

    public function addStockAction(Request $request)
    {

     if($request->ajax())
     {
      $outputKategori = '';

      $store = $request->get('id_store');
      $item = $request->get('id_item');

      if($store == '-- Silahkan Pilih Store --')
      {

         $outputKategori = '
            <option value="">-- store belum dipilih --</option>
        ';

        $id_item = '';

        $dataAdd = array(
            'kategori_data' => $outputKategori,
            'id_item' => $id_item
        );

        echo json_encode($dataAdd);

      }
      elseif ($item == '-- Silahkan Pilih Produk --') {

          $exist = pos_stock_desktop::where('id_store', $store)
          ->pluck('id_item');

            $kategori = pos_product_item_desktop::where('id_store', $store)
            ->whereNotIn('id_item', $exist)
            ->get();

            foreach ($kategori as $row){
                $outputKategori .= '
                    <option value="'.$row->id_item.'">'.$row->nama_item.'</option>
                ';
            }

            $id_item = '';

        $dataAdd = array(
            'kategori_data' => $outputKategori,
            'id_item' => $id_item
        );

        echo json_encode($dataAdd);
      }
      else{
          $exist = pos_stock_desktop::where('id_store', $store)
          ->pluck('id_item');
        $kategori = pos_product_item_desktop::where('id_store', $store)
        ->whereNotIn('id_item', $exist)
        ->get();
        $selected = pos_product_item_desktop::where('id_store', $store)
        ->where('id_item', $item)
        ->first();

        $selectedId = $selected->id_item;
        $selectedName = $selected->nama_item;

          foreach ($kategori as $row){
              if($row->id_item != $item){
                $outputKategori .= '
                    <option value="'.$row->id_item.'">'.$row->nama_item.'</option>
                ';
              } else{
                  $outputKategori .= '
                    <option value="'.$selectedId.'" selected>'.$selectedName.'</option>
                ';
              }
            }


            $dataAdd = array(
            'kategori_data' => $outputKategori,
            'id_item' => $selectedName
        );

        echo json_encode($dataAdd);
      }

      //return \View::make("app.masterMenu")
        //->with("kategori", $kategori)
        //->with("user", $user)
        //->with("stores", $stores)
        //->render();

        //return response()->json(['view' => view('kategori', compact('kategori'))->render()]);
     }
    }

    public function plusStock(Request $request){

        log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 3,
            'keterangan' => Auth::user()->name." Telah Menambah Stok :"."\nid item : ".$request->id_item."\nnama item : ".$request->nama_item."\nqty : ".$request->qty_plus."\nketerangan : ".$request->keterangan_plus,
        ]);

        $request->validate([
            'id' => 'required',
            'id_item' => 'required',
            'nama_item' => 'required',
            'qty_plus' => 'required',
            'keterangan_plus' => 'required',
        ]);

        $produk = pos_stock_desktop::findOrfail($request->id);
        $qty = $produk->qty;

        $produk->update([
            'id_item' => $request->id_item,
            'nama_item' => $request->nama_item,
            'qty' => $request->qty_plus + $qty,
            'updated_at' => Carbon::now(),
        ]);

        return redirect('dashboardStockManagement');

    }

    public function minStock(Request $request){

        log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 3,
            'keterangan' => Auth::user()->name." Telah Mengurangi Stok :"."\nid item : ".$request->id_item."\nnama item : ".$request->nama_item."\nqty : ".$request->qty_min."\nketerangan : ".$request->keterangan_min,
        ]);

        $request->validate([
            'id' => 'required',
            'id_item' => 'required',
            'nama_item' => 'required',
            'qty_min' => 'required',
            'keterangan_min' => 'required',
        ]);

        $produk = pos_stock_desktop::findOrfail($request->id);
        $qty = $produk->qty;

        $produk->update([
            'id_item' => $request->id_item,
            'nama_item' => $request->nama_item,
            'qty' => $qty - $request->qty_min,
            'updated_at' => Carbon::now(),
        ]);

        return redirect('dashboardStockManagement');

    }

}
