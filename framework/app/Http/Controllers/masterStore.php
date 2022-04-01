<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\pos_store_desktop;
use App\log_activity_desktop;

class masterStore extends Controller
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

        return view('app.masterStore', compact('user', 'stores'));
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
            'keterangan' => Auth::user()->name." Telah Menambahkan Store :"."\nNama Store : ".$request->nama_store,
        ]);

        $request->validate([
            'kode_store' => 'required',
            'nama_store' => 'required',
            'ip_kasir' => 'required',
            'ip_kitchen' => 'required',
            'ip_bar' => 'required',
        ]);

        $existID = pos_store_desktop::pluck('id')->toArray();
        $collections = range(1,1000);

        $smallestID = min(array_diff($collections, $existID));

        pos_store_desktop::insertGetId([
            'id' => $smallestID,
            'id_store' => $smallestID,
            'kode_store' => "MST-".$request->kode_store,
            'nama_store' => $request->nama_store,
            'menu_store' => $smallestID,
            'ip_kasir' => $request->ip_kasir,
            'ip_kitchen' => $request->ip_kitchen,
            'ip_bar' => $request->ip_bar,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect('dashboardMasterStore');
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
}
