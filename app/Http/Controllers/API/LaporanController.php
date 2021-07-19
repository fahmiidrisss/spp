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
    public function getLaporanUangMasuk($bulan)
    {
        $waktu = Carbon::now();

        $transaksi = DB::table('transaksis')
            ->join('santris', 'transaksis.nis', '=', 'santris.nis')
            ->join('kelas', 'santris.id_kelas', '=', 'kelas.id_kelas')
            ->select('transaksis.nis', 'santris.nama_santri', 'kelas.nama_kelas', 'transaksis.total_bayar')
            ->where([
                ['bulan', '=', $bulan],
                ['tahun', '=', $waktu->year]
            ])
            ->get();

        $jumlah_transaksi = Transaksi::where('bulan', $bulan)->get();
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
        $tunggakan = DB::table('santris')
            ->join('kelas', 'santris.id_kelas', '=', 'kelas.id_kelas')
            ->select('santris.nis', 'santris.nama_santri', 'kelas.nama_kelas', 'santris.jumlah_tunggakan')
            ->where('jumlah_tunggakan', '>', 0)
            ->get();

        $jumlah_santri = count($tunggakan);

        return response()->json(array(
            'message'       => 'Laporan Tunggakan Santri',
            'jumlah_santri' => $jumlah_santri,
            'transaksi'     => $tunggakan->toArray()),
            200
        );    
    }


}
