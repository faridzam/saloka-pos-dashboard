<?php

namespace App\Http\Controllers;

use App\login;
use App\User;
use App\log_activity_desktop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('welcome');
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
     * @param  \App\login  $login
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('user.profile', [
            'user' => User::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\login  $login
     * @return \Illuminate\Http\Response
     */
    public function edit(login $login)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\login  $login
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, login $login)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\login  $login
     * @return \Illuminate\Http\Response
     */
    public function destroy(login $login)
    {
        //
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            
            log_activity_desktop::create([
                'pic' => $request->name,
                'tipe' => 7,
                'keterangan' => $request->name." memasuki dashboard admin POS",
            ]);
            
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'login gagal!');
    }

    public function logout(Request $request)
        {
            
            log_activity_desktop::create([
                'pic' => Auth::user()->name,
                'tipe' => 8,
                'keterangan' => Auth::user()->name." meninggalkan dashboard admin POS",
            ]);
            
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/');
        }

    public function authenticateVoid(Request $request)
    {
        // $username = $request->username;
        // $password = $request->password;

        // $user = user_void_access_desktop::where('username', '=', $username)->first();

        // if (!$user) {
        //     return response()->json(['success'=>false, 'message' => 'Login Fail, please check username']);
        // }
        // if (!Hash::check($password, $user->password)) {
        //     return response()->json(['success'=>false, 'message' => 'Login Fail, pls check password']);
        // } else{
        //     //return response()->json(['success'=>true,'message'=>'success', 'data' => $user]);
        //     return redirect('dashboardInvoice');
        // }

        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if(Auth::guard('void')->attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/dashboardInvoice');
        }

        return back()->with('loginError', 'login gagal!');

    }

}
