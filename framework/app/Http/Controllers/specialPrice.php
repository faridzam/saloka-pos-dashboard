<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\pos_store_desktop;
use App\log_activity_desktop;
use App\pos_product_kategori_desktop;
use App\pos_product_item_desktop;
use App\pos_special_price_desktop;

class specialPrice extends Controller
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

        return view('app.specialPrice', compact('user', 'stores', 'dateNow', 'kategori', 'produk'));
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
        $produk = pos_product_item_desktop::where('id_store', $request->id_store)
        ->where('id_item', $request->id_item)
        ->first();
        
        $request->validate([
            'id_item' => 'required',
            'nama_item' => 'required',
            'id_kategori' => 'required',
            'id_store' => 'required',
            'sp_price' => 'required',
        ]);
        
        log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 2,
            'keterangan' => Auth::user()->name." Telah Menambahkan Special Price Pada Item :"."\nid item : ".$request->id_item."\nnama item : ".$produk->nama_item."\nSpecial Price : ".$request->sp_price." %",
        ]);
        
        pos_special_price_desktop::insertGetId([
            'id_item' => $request->id_item,
            'id_kategori' => $request->id_kategori,
            'id_store' => $request->id_store,
            'sp_price' => $request->sp_price,
            'min_order' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        return redirect('dashboardSpecialPrice');
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
      $outputDiscount = '';
      $outputKategori = '';
      
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

        $dataTable = pos_product_item_desktop::whereIn('id_item', $dataQuery)
        ->where('id_kategori', $cat)
        ->orderBy('id_item', 'asc')
        ->get();
        
        $dataTableDiscount = pos_special_price_desktop::whereIn('id_item', $dataQuery)
        ->where('id_kategori', $cat)
        ->orderBy('id_item', 'asc')
        ->get();
        
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
      $total_row_discount = $dataTableDiscount->count();
      if($total_row > 0)
      {
       foreach($dataTable as $row)
       {
            $produk = pos_product_item_desktop::where('id_store', $row->id_store)
            ->where('id_item', $row->id_item)
            ->first();
            
            $editButton= '<a class="btn btn-primary btn-lg open-modal" href="'.route('dashboardMasterMenu.edit', $row->id).'" data-toggle="modal" data-target="#editProduk" data-id="'.$row->id.'" data-item="'.$row->id_item.'" data-nama="'.$row->nama_item.'" data-kategori="'.$row->id_kategori.'" data-store="'.$row->id_store.'" data-harga="'.$row->harga.'" data-pajak="'.$row->pajak.'" data-harga_jual="'.$row->harga_jual.'" value='.$row->id.'> <i class="fas fa-edit"></i> </a>';
            $removeButton= '<a class="add-discount-button" data-toggle="modal" data-target="#addSpecialPrice" data-id="'.$row->id.'" data-item="'.$row->id_item.'" data-store="'.$row->id_store.'" data-name="'.$produk->nama_item.'" data-kategori="'.$row->id_kategori.'"><button class="btn btn-success btn-lg"> <i class="fas fa-plus"></i> </button></a>';
            
            $output .= '
            <tr data-id="'. $row->id_item.'">
             <th style="width: 10%;" scope="row">'.$row->id_item.'</th>
             <td style="width: 20%;" >'.$row->nama_item.'</td>
             <td style="width: 15%;" >'."Rp. ".number_format($row->hpp,0,",",".").'</td>
             <td style="width: 10%;" >'."Rp. ".number_format($row->pajak,0,",",".").'</td>
             <td style="width: 15%;" >'."Rp. ".number_format($row->harga_jual,0,",",".").'</td>
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
      
      if($total_row_discount > 0)
      {
       foreach($dataTableDiscount as $row)
       {
            $editButton= '<a class="btn btn-primary btn-lg open-modal" href="'.route('dashboardMasterMenu.edit', $row->id).'" data-toggle="modal" data-target="#editProduk" data-id="'.$row->id.'" data-item="'.$row->id_item.'" data-nama="'.$row->nama_item.'" data-kategori="'.$row->id_kategori.'" data-store="'.$row->id_store.'" data-harga="'.$row->harga.'" data-pajak="'.$row->pajak.'" data-harga_jual="'.$row->harga_jual.'" value='.$row->id.'> <i class="fas fa-edit"></i> </a>';
            $removeButton= '<a class="remove-discount" href="dashboardSpecialPrice-destroy/'.$row->id.'" onclick="return confirmation();"><button class="btn btn-danger btn-lg remove-button" data-id="'.$row->id.'"> <i class="fas fa-trash"></i> </button></a>';
            
            $outputDiscount .= '
            <tr data-id="'. $row->id_item.'">
             <th style="width: 15%;" scope="row">'.$row->id_item.'</th>
             <td style="width: 10%;" >'.$row->id_kategori.'</td>
             <td style="width: 10%;" >Rp. '."Rp. ".number_format($row->sp_price,0,",",".").'</td>
             <td style="width: 5%;" >'."under development".'</td>
             <td style="width: 5%;" >'.$removeButton.'</td>
            </tr>
            ';

       }
      }
      else
      {
       $outputDiscount = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row,
       'total_data_discount'  => $total_row_discount,
       'kategori_data' => $outputKategori,
       'table_data_discount' => $outputDiscount,
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
    
    public function destroySpecialPrice(Request $request, $id){
         
         $data1 = pos_special_price_desktop::where('id', $id)
         ->first();
         
         $data2 = pos_product_item_desktop::where('id_item', $data1->id_item)
         ->where('id_store', $data1->id_store)
         ->first();
         
         log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 4,
            'keterangan' => Auth::user()->name." Telah Menghapus Special Price :"."\nid : ".$id."\nid item : ".$data1->id_item."\nnama item : ".$data2->nama_item,
        ]);
            
        $produk = pos_special_price_desktop::findOrfail($id);
        $produk->delete();
        
        return redirect('dashboardSpecialPrice');
    }
    
}
