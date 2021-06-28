<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function createTransaksi(Request $request)
    {
        $request->validate([
            'nis'               => 'required',
            'jumlah_bulan'      => 'required',
            'total_bayar'       => 'required',
            'spp'               => 'required',
            'infaq'             => 'required',
            'id_admin'          => 'required'
        ]);

        // dd($request->all());
        for($i = 0; $i < $request->jumlah_bulan; $i++)
        {
            $transaksi = new Transaksi();
            $transaksi->nis = $request->nis;
            $transaksi->total_bayar = 50000;
            $transaksi->spp = 35000;
            $transaksi->infaq = 15000;
            $transaksi->status_transaksi = "Tunai";
            $transaksi->id_admin = $request->id_admin;
                $transaksi->save();
        }

        $transaksi->total_bayar = 50000*$request->jumlah_bulan;

        return response()->json([
            'message' => 'Transaksi Berhasil',
            'data_transaksi' => $transaksi
        ], 200);
    }

    public function index()
    {
        return "Ini Controller Transaksi";
    }
}
