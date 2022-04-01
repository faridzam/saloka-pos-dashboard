<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\pos_store_desktop;

class masterCategory extends Controller
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
        $stores = pos_store_desktop::where('kode_store', 'LIKE', '%'.'MST-'.'%')
        ->select('id_store', 'kode_store', 'nama_store', 'menu_store')
        ->get();

        return view('app.masterCategory', compact('user', 'stores'));
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
             <td style="width: 15%;" data-value="'.$row->hpp.'">'."Rp. ".number_format($row->hpp,0,",",".").'</td>
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

}
