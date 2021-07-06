<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\SantriController;
use App\Http\Controllers\API\TransaksiController;
use App\Http\Controllers\API\TransferController;
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
Route::post('/login', [AuthController::class, 'login']);

//Tes
Route::get('/tes', [AuthController::class, 'tesApi']);

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

//Transaksi
Route::post('/transaksi', [TransaksiController::class, 'createTransaksi']);
Route::get('/transaksi/hitung/uang', [TransaksiController::class, 'getUangMasuk']);
Route::get('/transaksi/hitung/santri', [TransaksiController::class, 'getSantriBayar']);
Route::get('/transaksi', [TransaksiController::class, 'getTransaksi']);
Route::get('/transaksi/{nis}', [TransaksiController::class, 'getTransaksiSantri']);

//Laporan
Route::get('/laporan/uangmasuk', [TransaksiController::class, 'createPDF']);

//Transfer
Route::get('/transfer/kodeunik', [TransferController::class, 'getKode']);
Route::post('/transfer', [TransferController::class, 'createTransfer']);