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


// Route::get('/laporan/uang', [LaporanController::class, 'getLaporan']);

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
Route::get('/transaksi/uang/bulanan', [TransaksiController::class, 'getUangBulanan']);
Route::get('/transaksi/total/bulanan', [TransaksiController::class, 'getTotalBulanan']);
Route::get('/transaksi/total/harian', [TransaksiController::class, 'getTotalHarian']);
Route::get('/transaksi/santri/bayar', [TransaksiController::class, 'getSantriBayar']);
Route::get('/transaksi/santri/tunggakan', [TransaksiController::class, 'getSantriTunggakan']);
Route::get('/transaksi', [TransaksiController::class, 'getTransaksi']);
Route::get('/transaksi/riwayat/{nis}', [TransaksiController::class, 'getTransaksiSantri']);
Route::get('/transaksi/kartu/{nis}', [TransaksiController::class, 'getKartuSantri']);
Route::post('/', [TransaksiController::class, 'tesTahun']);

//Transfer
Route::get('/transfer/kodeunik', [TransferController::class, 'getKode']);
Route::post('/transfer', [TransferController::class, 'createTransfer']);
Route::get('/transfer', [TransferController::class, 'getTransfer']);
Route::get('/transfer/failed', [TransferController::class, 'getFailedTransfer']);
Route::delete('/transfer/{id}', [TransferController::class, 'deleteTransfer']);
Route::post('/transfer/upload/gambar', [TransferController::class, 'uploadGambar']);
Route::put('/transfer', [TransferController::class, 'updateTransfer']);
Route::get('/transfer/{nis}', [TransferController::class, 'getStatusTransfer']);
Route::put('/transfer/{id}', [TransferController::class, 'failedTransfer']);


//Laporan
Route::get('/laporan/uang/{bulan}', [LaporanController::class, 'getLaporanUangMasuk']);
Route::get('/laporan/tunggakan', [LaporanController::class, 'getLaporanTunggakan']);
Route::get('/laporan/unduh/uang/{bulan}', [LaporanController::class, 'unduhLaporanUangMasuk']);
Route::get('/laporan/unduh/tunggakan', [LaporanController::class, 'unduhLaporanTunggakan']);
Route::get('/laporan/unduh/tagihan/{nis}', [LaporanController::class, 'unduhLaporanTagihan']);


//User
Route::post('/user', [AuthController::class, 'createUser']);
Route::delete('/user/{id}', [AuthController::class, 'deleteUser']);

