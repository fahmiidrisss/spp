<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\SantriController;
use App\Http\Controllers\API\TransaksiController;
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
Route::post('/admin/create', [AdminController::class, 'createAdmin']);
Route::get('/admin/show', [AdminController::class, 'showAdmin']);
Route::put('/admin/update/{id}', [AdminController::class, 'updateAdmin']);
Route::delete('/admin/delete/{id}', [AdminController::class, 'deleteAdmin']);

//Kelola Data Santri
Route::post('/santri/create', [SantriController::class, 'createSantri']);
Route::get('/santri/show', [SantriController::class, 'showSantri']);
Route::get('/santri/detail/{id}', [SantriController::class, 'detailSantri']);
Route::put('/santri/update/{id}', [SantriController::class, 'updateSantri']);
Route::delete('/santri/delete/{id}', [SantriController::class, 'deleteSantri']);

//Transaksi
Route::post('/transaksi/create', [TransaksiController::class, 'createTransaksi']);
Route::get('/transaksi/tes', [TransaksiController::class, 'index']);