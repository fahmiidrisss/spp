<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function createTransaksi(Request $request, $jumlah_bulan)
    {
        $request->validate([
            'nis'               => 'required',
            'total_transaksi'   => 'required',
            'spp'               => 'required',
            'infaq'             => 'required',
            'status_transaksi'  => 'required',
            'id_admin'          => 'required',
            'tanggal_transaksi' => 'required'  
        ]);

        // dd($request->all());
        $transaksi = new Transaksi();
        $transaksi->nis = $request->nis;
        $transaksi->total_transaksi = $request->total_transaksi;
        $transaksi->spp = $request->spp;
        $transaksi->infaq = $request->infaq;
        $transaksi->status_transaksi = $request->status_transaksi;
        $transaksi->id_admin = $request->id_admin;
        for($i = 1; $i <= $jumlah_bulan; $i++)
        {
            $transaksi->save();
        }

        return response()->json([
            'message' => 'Data Transaksi Berhasil Ditambahkan',
            'data_transaksi' => $transaksi
        ], 200);
    }
}
