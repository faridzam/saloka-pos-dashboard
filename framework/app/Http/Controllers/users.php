<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pos_kasir_desktop;
use App\log_activity_desktop;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class users extends Controller
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

        return view('app.users', compact('user'));
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
            'keterangan' => Auth::user()->name." Telah Menambahkan User :"."\nusername : ".$request->name."\ntipe user : ".$request->tipe_user,
        ]);

        $request->validate([
            'tipe_user' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if($request->tipe_user == 1){

            pos_kasir_desktop::insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        } elseif ($request->tipe_user == 2) {

            User::insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        } else {
            return redirect()->back();
        }

        return redirect('dashboardUsers');
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

      $userType = $request->get('userType');

      if($userType == 'kasir')
      {
        $dataTable = pos_kasir_desktop::where('name', '!=', 'faridzam')->get();

        $total_row = $dataTable->count();
          if($total_row > 0)
          {
           foreach($dataTable as $row)
           {
                $plusButton= '<a class="btn btn-primary btn-lg open-modal" data-toggle="modal" data-target="#plusStock" data-id="'.$row->id.'" data-item="'.$row->id_item.'" data-nama="'.$row->nama_item.'" data-qty="'.$row->qty.'" data-min_qty="'.$row->min_qty.'" value='.$row->id.'> <i class="fas fa-edit"></i> </a>';
                $removeButton= '<a class="btn btn-danger btn-lg remove-user" href="dashboardUsers-destroyKasir/'.$row->id.'" id="remove-user" onclick="return confirmation();" data-id="'.$row->id.'" value='.$row->id.'> <i class="fas fa-trash"></i></a>';

                $output .= '
                <tr data-id="'.$row->id.'">
                 <th style="width: 40%;" scope="row">'.$row->name.'</th>
                 <td style="width: 40%;" >'."***********".'</td>
                 <td style="width: 15%;" >'."under development".'</td>
                 <td style="width: 15%;" >'.$removeButton.'</td>
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


      }
      elseif ($userType == 'dashboard') {
          $dataTable = User::where('name', '!=', 'faridzam')->get();

          $total_row = $dataTable->count();
          if($total_row > 0)
          {
           foreach($dataTable as $row)
           {
                $plusButton= '<a class="btn btn-primary btn-lg open-modal" data-toggle="modal" data-target="#plusStock" data-id="'.$row->id.'" data-item="'.$row->id_item.'" data-nama="'.$row->nama_item.'" data-qty="'.$row->qty.'" data-min_qty="'.$row->min_qty.'" value='.$row->id.'> <i class="fas fa-edit"></i> </a>';
                $removeButton= '<a class="btn btn-danger btn-lg remove-user" href="dashboardUsers-destroyAdmin/'.$row->id.'" id="remove-user" onclick="return confirmation();" data-id="'.$row->id.'" value='.$row->id.'> <i class="fas fa-trash"></i></a>';

                $output .= '
                <tr data-id="'.$row->id.'">
                 <th style="width: 40%;" scope="row">'.$row->name.'</th>
                 <td style="width: 40%;" >'."***********".'</td>
                 <td style="width: 15%;" >'."under development".'</td>
                 <td style="width: 15%;" >'.$removeButton.'</td>
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

      }
      else
      {
          $dataTable = collect();
        $output = '
        <tr>
            <td align="center" colspan="5">Store Belum Dipilih</td>
        </tr>
        ';
      }

      $data = array(
       'table_data'  => $output,
      );

      echo json_encode($data);
     }
    }

    public function destroyKasir(Request $request, $id){

         $data = pos_kasir_desktop::findOrfail($id);
         log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 4,
            'keterangan' => Auth::user()->name." Telah Menghapus User :"."\nid : ".$id."\nnama user : ".$data->name,
        ]);

        $produk = pos_kasir_desktop::findOrfail($id);
        $produk->delete();

        return redirect('dashboardUsers');
    }

    public function destroyAdmin(Request $request, $id){

         $data = User::findOrfail($id);
         log_activity_desktop::create([
            'pic' => Auth::user()->name,
            'tipe' => 4,
            'keterangan' => Auth::user()->name." Telah Menghapus User :"."\nid : ".$id."\nnama user : ".$data->name,
        ]);

        $produk = User::findOrfail($id);
        $produk->delete();

        return redirect('dashboardUsers');
    }
}
