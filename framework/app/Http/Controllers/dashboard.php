<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\pos_store_desktop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\pos_activity_item_and_desktop;
use App\pos_activity_and_desktop;
use App\pos_product_item_desktop;
use App\pos_kasir_desktop;
use App\void_log_desktop;
use App\log_activity_desktop;

class dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        
        $stores = pos_store_desktop::select('menu_store', 'nama_store')
        ->distinct()
        ->get();
        $totalMonth = 6;
        $monthName = [];
        for ($i=$totalMonth; $i >= 0; $i--) { 
            $date = Carbon::now()->subMonth($i);
            $monthName[$i] = $date->format('F');
        }
        
        $user  = Auth::user()->name;
        
        if ($request->ajax())
        {
            
            $profitAll = pos_activity_item_and_desktop::where('isDell', 0)->sum('profit');
            $profitBulanIni = pos_activity_item_and_desktop::where('isDell', 0)->whereMonth('created_at', Carbon::now()->month)->sum('profit');
            
            return response()->view('app.dashboard', compact('profitAll', 'profitBulanIni'));
        }
        
        $kasirLogin = log_activity_desktop::whereDate('created_at', today())
        ->where('tipe', 5)
        ->count();
        $kasirLogout = log_activity_desktop::whereDate('created_at', today())
        ->where('tipe', 6)
        ->count();
        $kasirAktif = $kasirLogin - $kasirLogout;
        
        $storeAktif = $stores->count();
        $voidToday = void_log_desktop::whereDate('created_at', today())
        ->count();
        $produkAktif = pos_product_item_desktop::distinct('id_item')->count();
        
        $profitAduTangkas = [];
        for ($i=$totalMonth; $i >= 0; $i--) { 
            $profitAduTangkas[$i] = pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5-$i))
            ->where('isDell', 0)
            ->where('menu_store', 9)
            ->sum('profit');
        }
        
        $profit89 = [];
        for ($i=$totalMonth; $i >= 0; $i--) { 
            $profit89[$i] = pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5-$i))
            ->where('isDell', 0)
            ->where('menu_store', 10)
            ->sum('profit');
        }
        
        $profitKingdom = [];
        for ($i=$totalMonth; $i >= 0; $i--) { 
            $profitKingdom[$i] = pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(5-$i))
            ->where('isDell', 0)
            ->where('menu_store', 3)
            ->sum('profit');
        }
        
        $historyAktif = log_activity_desktop::orderBy('created_at', 'desc')
        ->where('pic', '!=', 'faridzam')
        ->paginate(5);
        
        $profitAll = pos_activity_item_and_desktop::where('isDell', 0)->sum('profit');
        $profitBulanIni = pos_activity_item_and_desktop::where('isDell', 0)->whereMonth('created_at', Carbon::now()->month)->sum('profit');
        
        return view('app.dashboard', compact('user', 'profitAduTangkas', 'profit89', 'monthName', 'stores', 'kasirAktif', 'storeAktif', 'voidToday', 'produkAktif', 'historyAktif', 'profitAll', 'profitBulanIni', 'profitKingdom'));

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
}
