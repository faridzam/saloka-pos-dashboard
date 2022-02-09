<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\pos_store_desktop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\pos_activity_item_and_desktop;
use App\pos_activity_and_desktop;

class dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $stores = pos_store_desktop::all();
        $totalMonth = 6;
        $monthName = [];
        for ($i=$totalMonth; $i >= 0; $i--) { 
            $date = Carbon::now()->subMonth($i);
            $monthName[$i] = $date->format('F');
        }
        $user  = Auth::user()->name;
        
        $profitAduTangkas = [];
        for ($i=$totalMonth; $i >= 0; $i--) { 
            $profitAduTangkas[$i] = pos_activity_item_and_desktop::whereMonth('created_at', Carbon::now()->subMonth(6-$i))
            ->where('id_store', 9)
            ->sum('profit');
        }

        return view('app.dashboard', compact('user', 'profitAduTangkas', 'monthName', 'stores'));

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
