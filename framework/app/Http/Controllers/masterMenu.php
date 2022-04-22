<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\pos_store_desktop;
use App\pos_stock_desktop;
use App\log_activity_desktop;
use App\pos_product_kategori_desktop;
use App\pos_product_item_desktop;


class masterMenu extends Controller
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

        $produk = pos_product_item_desktop::get('id');

        $kategori = pos_product_kategori_desktop::all();

        return view('app.masterMenu', compact('user', 'stores', 'dateNow', 'kategori', 'produk'));
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
            'keterangan' => Auth::user()->name." Telah Menambahkan Produk :"."\nid item : ".$request->id_item."\nnama item : ".$request->nama_item,
        ]);

        $request->validate([
            'id_item' => 'required',
            'nama_item' => 'required',
            'id_kategori' => 'required',
            'id_store' => 'required',
            'harga' => 'required',
            'pajak' => 'required',
            'harga_jual' => 'required',
            'isDell' => 'required',
        ]);

        pos_product_item_desktop::insertGetId([
            'id_item' => $request->id_item,
            'nama_item' => $request->nama_item,
            'id_kategori' => $request->id_kategori,
            'id_store' => $request->id_store,
            'harga' => $request->harga,
            'pajak' => $request->pajak,
            'harga_jual' => $request->harga_jual,
            'isDell' => $request->isDell,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect('dashboardMasterMenu');
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
        $produk = pos_product_item_desktop::findOrFail($id);
        return view('app.modals.editProduk', compact('produk'));
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

        $produk = pos_product_item_desktop::findOrfail($request-id);

        $produk->id = request('id');
        $produk->id_item = request('id_item');
        $produk->nama_item = request('nama_item');
        $produk->id_kategori = request('id_kategori');
        $produk->id_store = request('id_store');
        $produk->harga = request('harga');
        $produk->pajak = request('pajak');
        $produk->harga_jual = request('harga_jual');
        $produk->isDell = request('isDell');
        $produk->created_at = Carbon::now();
        $produk->updated_at = Carbon::now();

        $produk->save();

        return json_encode(array('statusCode'=>200));

        //return back();
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
      $outputKategori = '<option value="*">'."All".'</option>';

      $store = $request->get('id_store');
      $cat = $request->get('id_kategori');

      if($store != '-- Silahkan Pilih Store --')
      {
        $dataQuery = pos_product_item_desktop::where('id_store', $store)
        ->pluck('id_item');

        $kategoriQuery = pos_product_kategori_desktop::where('id_store', $store)
        ->pluck('id_kategori');

        $kategori = pos_product_kategori_desktop::where('id_store', $store)
        ->get();

        if($cat == '*'){

            $dataTable = pos_product_item_desktop::whereIn('id_item', $dataQuery)
            ->orderBy('id_item', 'asc')
            ->get();

        } else{

            $dataTable = pos_product_item_desktop::whereIn('id_item', $dataQuery)
            ->where('id_kategori', $cat)
            ->orderBy('id_item', 'asc')
            ->get();

        }

        foreach ($kategori as $row){
            $outputKategori .= '
                <option value="'.$row->id_kategori.'">'.$row->nama_kategori.'</option>
            ';
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
       foreach($dataTable as $row)
       {
            $editButton= '<a class="btn btn-primary btn-lg open-modal" href="'.route('dashboardMasterMenu.edit', $row->id).'" data-toggle="modal" data-target="#editProduk" data-id="'.$row->id.'" data-item="'.$row->id_item.'" data-nama="'.$row->nama_item.'" data-kategori="'.$row->id_kategori.'" data-store="'.$row->id_store.'" data-harga="'.$row->harga.'" data-pajak="'.$row->pajak.'" data-harga_jual="'.$row->harga_jual.'" value='.$row->id.'> <i class="fas fa-edit"></i> </a>';
            $removeButton= '<a class="remove-product" href="dashboardMasterMenu-destroy/'.$row->id.'" onclick="return confirmation();"><button class="btn btn-danger btn-lg remove-button" data-id="'.$row->id.'" data-nama="'.$row->nama_item.'"> <i class="fas fa-trash"></i> </button></a>';

            $output .= '
            <tr data-id="'. $row->id_item.'">
             <td style="width: 10%;" scope="row" data-value="'.$row->id_item.'">'.$row->id_item.'</td>
             <td style="width: 20%;" data-value="'.$row->nama_item.'">'.$row->nama_item.'</td>
             <td style="width: 15%;" data-value="'.$row->harga.'">'."Rp. ".number_format($row->harga,0,",",".").'</td>
             <td style="width: 10%;" data-value="'.$row->pajak.'">'."Rp. ".number_format($row->pajak,0,",",".").'</td>
             <td style="width: 15%;" data-value="'.$row->harga_jual.'">'."Rp. ".number_format($row->harga_jual,0,",",".").'</td>
             <td style="width: 5%;" >'.$editButton.'</td>
             <td style="width: 5%;" >'.$removeButton.'</td>
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
       'kategori_data' => $outputKategori,
      );

      echo json_encode($data);

      //return \View::make("app.masterMenu")
        //->with("kategori", $kategori)
        //->with("user", $user)
        //->with("stores", $stores)
        //->render();

        //return response()->json(['view' => view('kategori', compact('kategori'))->render()]);
     }
    }

    public function updateItem(Request $request){

        log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 3,
            'keterangan' => Auth::user()->name." Telah Mengedit Produk :"."\nid : ".$request->id."\nid item : ".$request->id_item."\nnama item : ".$request->nama_item."\nhpp : ".$request->harga."\nharga : ".$request->harga_jual,
        ]);

        $request->validate([
            'id' => 'required',
            'id_item' => 'required',
            'nama_item' => 'required',
            'id_kategori' => 'required',
            'id_store' => 'required',
            'harga' => 'required',
            'pajak' => 'required',
            'harga_jual' => 'required',
        ]);

        $produk = pos_product_item_desktop::findOrfail($request->id);

        $produk->update([
            'id' => $request->id,
            'id_item' => $request->id_item,
            'nama_item' => $request->nama_item,
            'id_kategori' => $request->id_kategori,
            'id_store' => $request->id_store,
            'harga' => $request->harga,
            'pajak' => $request->pajak,
            'harga_jual' => $request->harga_jual,
            'isDell' => $request->isDell,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect('dashboardMasterMenu');
    }

    public function destroyItem(Request $request, $id){

         $data1 = pos_product_item_desktop::where('id', $id)
         ->value('id_item');
         $data2 = pos_product_item_desktop::where('id', $id)
         ->value('nama_item');

         log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 4,
            'keterangan' => Auth::user()->name." Telah Menghapus Produk :"."\nid : ".$request->id."\nid item : ".$data1."\nnama item : ".$data2,
        ]);

        $produk = pos_product_item_desktop::findOrfail($id);
        $produk->delete();

        return redirect('dashboardMasterMenu');
    }

    public function addProductAction(Request $request)
    {

     if($request->ajax())
     {
      $outputKategori = '';

      $store = $request->get('id_store');
      $cat = $request->get('id_kategori');

      if($store == '-- Silahkan Pilih Store --')
      {

         $outputKategori = '
            <option value="">-- store belum dipilih --</option>
        ';

        $dataAdd = array(
            'kategori_data' => $outputKategori,
        );

        echo json_encode($dataAdd);

      }
      elseif ($cat == '-- Silahkan Pilih Kategori --') {

            $kategori = pos_product_kategori_desktop::where('id_store', $store)
            ->get();

            foreach ($kategori as $row){
                $outputKategori .= '
                    <option value="'.$row->id_kategori.'">'.$row->nama_kategori.'</option>
                ';
            }

        $dataAdd = array(
            'kategori_data' => $outputKategori,
        );

        echo json_encode($dataAdd);
      }
      else{
        $kategori = pos_product_kategori_desktop::where('id_store', $store)
        ->get();
        $selected = pos_product_kategori_desktop::where('id_store', $store)
        ->where('id_kategori', $cat)
        ->get();
        $selectedId = $selected->id_kategori;
        $selectedName = $selected->nama_kategori;

          foreach ($kategori as $row){
              if($row->id_kategori != $cat){
                $outputKategori .= '
                    <option value="'.$row->id_kategori.'">'.$row->nama_kategori.'</option>
                ';
              } else{
                  $outputKategori .= '
                    <option value="'.$selectedId.'" selected>'.$selectedName.'</option>
                ';
              }
            }

            $dataAdd = array(
            'kategori_data' => $outputKategori,
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
}
