<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\pos_store_desktop;
use App\pos_product_kategori_desktop;
use App\log_activity_desktop;

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
        $store = pos_store_desktop::where('id_store', $request->id_store)->value('nama_store');

        $request->validate([
            'id_store' => 'required',
            'jenis_kategori' => 'required',
            'id_kategori' => 'required',
            'nama_kategori' => 'required',
        ]);

        log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 2,
            'keterangan' => Auth::user()->name." Telah Menambahkan kategori :"."\nid kategori : ".$request->id_kategori."\nnama kategori : ".$request->nama_kategori."\nstore : ".$store,
        ]);

        pos_product_kategori_desktop::insertGetId([
            'id_kategori' => $request->id_kategori,
            'id_store' => $request->id_store,
            'nama_kategori' => $request->nama_kategori,
            'isDell' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect('dashboardMasterCategory');
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

        $dataTable = pos_product_kategori_desktop::where('id_store', $request->get('id_store'))
        ->orderBy('nama_kategori', 'asc')
        ->get();

      } else{
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
            $editButton= '<a class="btn btn-primary btn-lg open-modal" data-toggle="modal" data-target="#editCategory" data-id="'.$row->id.'" data-kategori="'.$row->id_kategori.'" data-nama="'.$row->nama_kategori.'" data-store="'.$row->id_store.'" value='.$row->id.'> <i class="fas fa-edit"></i> </a>';
            $removeButton= '<a class="remove-category" href="dashboardMasterCategory-destroy/'.$row->id.'" onclick="return confirmation();"><button class="btn btn-danger btn-lg remove-button" data-id="'.$row->id.'" data-nama="'.$row->nama_item.'"> <i class="fas fa-trash"></i> </button></a>';

            $namaStore = pos_store_desktop::where('id_store', $row->id_store)->value('nama_store');

            if($row->id_kategori > 500){
                $jenisKategori = 'non-konsumsi';
            } elseif ($row->id_kategori % 2 == 0) {
                $jenisKategori = 'makanan';
            } elseif ($row->id_kategori % 2 != 0){
                $jenisKategori = 'minuman';
            } else{
                $jenisKategori = 'lainnya';
            }

            $output .= '
            <tr data-id="'. $row->id_item.'">
             <td style="width: 10%;" scope="row" data-value="'.$row->id_kategori.'">'.$row->id_kategori.'</td>
             <td style="width: 20%;" data-value="'.$row->nama_kategori.'">'.$row->nama_kategori.'</td>
             <td style="width: 15%;" data-value="'.$namaStore.'">'.$namaStore.'</td>
             <td style="width: 10%;" data-value="'.$jenisKategori.'">'.$jenisKategori.'</td>
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

    public function searchAdd(Request $request)
    {

     if($request->ajax())
     {

        if($request->jenis_kategori == 3){
            $id_max = pos_product_kategori_desktop::where('id_kategori', '>', 500)
            ->where('id_kategori', '<', 1000)
            ->max('id_kategori');

            $id_available = $id_max + 1;
        } elseif ($request->jenis_kategori  == 2) {
            $id_array = pos_product_kategori_desktop::whereRaw('(id_kategori % 2) != 0')
            ->where('id_kategori', '<=', 500)
            ->pluck('id_kategori')
            ->toArray();

            $id_available = max($id_array)+2;
        } elseif($request->jenis_kategori == 1){
            $id_array = pos_product_kategori_desktop::whereRaw('(id_kategori % 2) = 0')
            ->where('id_kategori', '<=', 500)
            ->pluck('id_kategori')
            ->toArray();

            $id_available = max($id_array)+2;
        } else{
            $id_available = 'jenis kategori belum dipilih';
        }


      $data = array(
       'id_kategori'  => $id_available,
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

    public function destroyCategory(Request $request, $id){

         $data = pos_product_kategori_desktop::findOrfail($id);

         log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 4,
            'keterangan' => Auth::user()->name." Telah Menghapus kategori :"."\nid : ".$id."\nid kategori : ".$data->id_kategori."\nnama kategori : ".$data->nama_kategori,
        ]);

        $data->delete();

        return redirect('dashboardMasterCategory');
    }

    public function updateCategory(Request $request){

        $request->validate([
            'id' => 'required',
            'nama_kategori' => 'required',
            'id_kategori' => 'required',
            'id_store' => 'required',
        ]);

        log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 3,
            'keterangan' => Auth::user()->name." Telah Mengedit Kategori :"."\nid : ".$request->id."\nid kategori : ".$request->id_kategori."\nnama kategori : ".$request->nama_kategori."\nid store : ".$request->id_store,
        ]);

        $category = pos_product_kategori_desktop::findOrfail($request->id);

        $category->update([
            'id' => $request->id,
            'nama_kategori' => $request->nama_kategori,
            'id_kategori' => $request->id_kategori,
            'id_store' => $request->id_store,
            'isDell' => 0,
            'updated_at' => Carbon::now(),
        ]);

       return redirect('dashboardMasterCategory');
   }

}
