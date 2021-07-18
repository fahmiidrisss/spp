<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\SantriController;
use App\Http\Controllers\API\TransaksiController;
use App\Http\Controllers\API\TransferController;
use App\Http\Controllers\API\LaporanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware'=>'auth:sanctum'], function()
{   
    //Logout User
    Route::get('/logout', [AuthController::class, 'logout']);
});

//Login User
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
Route::post('/santri/login', [AuthController::class, 'loginSantri']);

//Kelola Data Admin
Route::post('/admin', [AdminController::class, 'createAdmin']);
Route::get('/admin', [AdminController::class, 'getAdmin']);
Route::get('/admin/{id}', [AdminController::class, 'detailAdmin']);
Route::put('/admin/{id}', [AdminController::class, 'updateAdmin']);
Route::delete('/admin/{id}', [AdminController::class, 'deleteAdmin']);

//Kelola Data Santri
Route::post('/santri', [SantriController::class, 'createSantri']);
Route::get('/santri', [SantriController::class, 'getSantri']);
Route::get('/santri/{nis}', [SantriController::class, 'detailSantri']);
Route::put('/santri/{nis}', [SantriController::class, 'updateSantri']);
Route::delete('/santri/{nis}', [SantriController::class, 'deleteSantri']);
Route::get('/santri/status/{nis}', [SantriController::class, 'cekStatusSPP']);
Route::put('/santri/password/{nis}', [SantriController::class, 'updatePassword']);

//Transaksi
Route::post('/transaksi', [TransaksiController::class, 'createTransaksi']);
Route::get('/transaksi/hitung/uang', [TransaksiController::class, 'getUangMasuk']);
Route::get('/transaksi/hitung/santri', [TransaksiController::class, 'getSantriBayar']);
Route::get('/transaksi', [TransaksiController::class, 'getTransaksi']);
Route::get('/transaksi/{nis}', [TransaksiController::class, 'getTransaksiSantri']);
// Route::get('/transaksi/laporan/uang', [TransaksiController::class, 'getLaporanTransaksi']);

//Laporan
Route::get('/laporan/uangmasuk', [LaporanController::class, 'getLaporanTransaksi']);
Route::get('/laporan/tunggakan', [LaporanController::class, 'getLaporanTunggakan']);
// Route::get('/laporan/uang', [LaporanController::class, 'getLaporan']);

//Transfer
Route::get('/transfer/kodeunik', [TransferController::class, 'getKode']);
Route::post('/transfer', [TransferController::class, 'createTransfer']);
Route::get('/transfer', [TransferController::class, 'getTransfer']);
Route::delete('/transfer/{id}', [TransferController::class, 'deleteTransfer']);

//User
Route::post('/user', [AuthController::class, 'createUser']);
Route::delete('/user/{id}', [AuthController::class, 'deleteUser']);