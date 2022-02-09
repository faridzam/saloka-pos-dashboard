<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->middleware('guest');
Route::post('/', [LoginController::class, 'authenticate'])->middleware('guest');


Route::resource('dashboard', dashboard::class)->middleware('auth');

Route::resource('dashboardLaporanPenjualan', laporanPenjualan::class)->middleware('auth');
Route::get('dashboardLaporanPenjualan-search','laporanPenjualan@search')->name('dashboardLaporanPenjualan.search')->middleware('auth');
Route::get('dashboardLaporanPenjualan-export','laporanPenjualan@exportLaporanPenjualan')->name('dashboardLaporanPenjualan.export')->middleware('auth');

Route::resource('dashboardVoidTransaksi', VoidLogDesktopController::class)->middleware('auth');
Route::get('dashboardVoidTransaksi-search', 'VoidLogDesktopController@search')->name('dashboardVoidTransaksi.search')->middleware('auth');
Route::post('authenticateVoid', 'VoidLogDesktopController@voidVerification')->name('void.verification')->middleware('auth');
Route::get('void-invoice/{no_invoice}', 'VoidLogDesktopController@voidInvoice')->name('void.invoice')->middleware('auth');