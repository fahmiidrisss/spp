<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function getLaporanUangMasuk(Request $request)
    {
        $waktu = Carbon::now();

        $transaksi = DB::table('transaksis')
            ->join('santris', 'transaksis.nis', '=', 'santris.nis')
            ->join('kelas', 'santris.id_kelas', '=', 'kelas.id_kelas')
            ->select('transaksis.nis', 'santris.nama_santri', 'kelas.nama_kelas', 'transaksis.total_bayar')
            ->where([
                ['bulan', '=', $request->bulan],
                ['tahun', '=', $waktu->year]
            ])
            ->get();

        $jumlah_transaksi = Transaksi::where('bulan', $request->bulan)->get();
        // $total = 50000*count($jumlah_transaksi);

        return response()->json(array(
            'message'       => 'Laporan Uang Masuk Bulan Ini',
            'uang_masuk'    => count($jumlah_transaksi)*50000,
            'transaksi'     => $transaksi->toArray()),
            200
        );
    }

    public function getLaporanTunggakan()
    {
        return response()->json([
            'message'   => 'SPP Bulan ini Lunas'
        ], 200);
    }
}
