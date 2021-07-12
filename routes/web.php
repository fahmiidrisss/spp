<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LaporanController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware'=>'auth:sanctum'], function()
{
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
    
    
    //Logout User
    Route::get('/logout', [AuthController::class, 'logout']);
});

//Login User
Route::post('/login', [AuthController::class, 'login']);

Route::get('/', [LaporanController::class, 'showTransaksi']);

Route::get('/transaksi/pdf', [LaporanController::class, 'getLaporanUangMasuk']);