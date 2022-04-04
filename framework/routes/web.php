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

Route::get('/', [LoginController::class, 'index'])->name('login.page');
Route::post('/', [LoginController::class, 'authenticate'])->middleware('guest');
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');


Route::resource('dashboard', dashboard::class)->middleware('auth');

Route::resource('dashboardLaporanPenjualan', laporanPenjualan::class)->middleware('auth');
Route::get('dashboardLaporanPenjualan-search','laporanPenjualan@search')->name('dashboardLaporanPenjualan.search')->middleware('auth');
Route::get('dashboardLaporanPenjualan-export','laporanPenjualan@exportLaporanPenjualan')->name('dashboardLaporanPenjualan.export')->middleware('auth');

Route::resource('dashboardReportItemSales', dashboardReportItemSales::class)->middleware('auth');
Route::get('dashboardReportItemSales-search','dashboardReportItemSales@search')->name('dashboardReportItemSales.search')->middleware('auth');
Route::get('dashboardReportItemSales-export','dashboardReportItemSales@exportLaporanPenjualan')->name('dashboardReportItemSales.export')->middleware('auth');

Route::resource('dashboardVoidTransaksi', VoidLogDesktopController::class)->middleware('auth');
Route::get('dashboardVoidTransaksi-search', 'VoidLogDesktopController@search')->name('dashboardVoidTransaksi.search')->middleware('auth');
Route::post('authenticateVoid', 'VoidLogDesktopController@voidVerification')->name('void.verification')->middleware('auth')->middleware('roleChecker:void');

Route::resource('dashboardMasterStore', masterStore::class)->middleware('auth');

Route::resource('dashboardMasterCategory', masterCategory::class)->middleware('auth');
Route::get('dashboardMasterCategory-search', 'masterCategory@search')->name('dashboardMasterCategory.search')->middleware('auth');
Route::get('dashboardMasterCategory-destroy/{id}', 'masterCategory@destroyCategory')->name('dashboardMasterCategory.destroy')->middleware('auth');
Route::get('dashboardMasterCategory-search-add', 'masterCategory@searchAdd')->name('dashboardMasterCategory.search.add')->middleware('auth');


Route::resource('dashboardMasterMenu', masterMenu::class)->middleware('auth');
Route::get('dashboardMasterMenu-search','masterMenu@search')->name('masterMenu.search')->middleware('auth');
Route::get('dashboardMasterMenu-addProductAction','masterMenu@addProductAction')->name('masterMenu.add.product.action')->middleware('auth');
Route::post('dashboardMasterMenu-update','masterMenu@updateItem')->name('masterMenu.update')->middleware('auth');
Route::get('dashboardMasterMenu-destroy/{id}','masterMenu@destroyItem')->name('masterMenu.destroy')->middleware('auth');

Route::resource('dashboardDiscount', discount::class)->middleware('auth');
Route::get('dashboardDiscount-search','discount@search')->name('dashboardDiscount.search')->middleware('auth');
Route::get('dashboardDiscount-destroy/{id}','discount@destroyDiscount')->name('dashboardDiscount.destroy')->middleware('auth');

Route::resource('dashboardSpecialPrice', specialPrice::class)->middleware('auth');
Route::get('dashboardSpecialPrice-search','specialPrice@search')->name('dashboardSpecialPrice.search')->middleware('auth');
Route::get('dashboardSpecialPrice-destroy/{id}','specialPrice@destroySpecialPrice')->name('dashboardSpecialPrice.destroy')->middleware('auth');

Route::resource('dashboardStockManagement', stockManagement::class)->middleware('auth');
Route::get('dashboardStockManagement-search','stockManagement@search')->name('stockManagement.search')->middleware('auth');
Route::get('dashboardStockManagement-addStock','stockManagement@addStockAction')->name('stockManagement.addStockAction')->middleware('auth');
Route::get('dashboardStockManagement-plusStock','stockManagement@plusStock')->name('stockManagement.plusStock')->middleware('auth');
Route::get('dashboardStockManagement-minStock','stockManagement@minStock')->name('stockManagement.minStock')->middleware('auth');

Route::resource('dashboardUsers', users::class)->middleware('auth')->middleware('roleChecker:users');
Route::get('dashboardUsers-search','users@search')->name('dashboardUsers.search')->middleware('auth');
Route::get('dashboardUsers-destroyKasir/{id}','users@destroyKasir')->name('dashboardUsers.destroyKasir')->middleware('auth');
Route::get('dashboardUsers-destroyAdmin/{id}','users@destroyAdmin')->name('dashboardUsers.destroyAdmin')->middleware('auth');
