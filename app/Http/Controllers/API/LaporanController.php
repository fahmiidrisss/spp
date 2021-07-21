<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanController extends Controller
{
    public $data_transaksi;
    public function getLaporanUangMasuk($bulan)
    {
        $waktu = Carbon::now();

        $transaksi = DB::table('transaksis')
            ->join('santris', 'transaksis.nis', '=', 'santris.nis')
            ->join('kelas', 'santris.id_kelas', '=', 'kelas.id_kelas')
            ->select('transaksis.id_transaksi', 'transaksis.tanggal_transaksi', 'transaksis.nis', 
            'santris.nama_santri', 'kelas.nama_kelas', 'transaksis.total_bayar', 
            'transaksis.status_transaksi')
            ->where([
                ['bulan', '=', $bulan],
                ['tahun', '=', $waktu->year]
            ])
            ->get();

        $jumlah_transaksi = Transaksi::where('bulan', $bulan)->get();
        // $total = 50000*count($jumlah_transaksi);

        return response()->json(array(
            'message'       => 'Laporan Uang Masuk Bulan '.$bulan,
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
            'tunggakan'     => $tunggakan->toArray()),
            200
        );    
    }

    public function unduhLaporanUangMasuk($bulan)
    {
        $tanggal = Carbon::now();
        $namaBulan = [
            '0' => null, 
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10'=> 'Oktober',
            '11'=> 'November',
            '12'=> 'Desember'
        ];  

        $transaksi = DB::table('transaksis')
            ->join('santris', 'transaksis.nis', '=', 'santris.nis')
            ->join('kelas', 'santris.id_kelas', '=', 'kelas.id_kelas')
            ->select('transaksis.nis', 'santris.nama_santri', 'kelas.nama_kelas', 'transaksis.total_bayar', 'transaksis.status_transaksi')
            ->where([
                ['bulan', '=', $bulan],
                ['tahun', '=', $tanggal->year]
            ])
            ->get();
        $data = [
            'title'     => 'Laporan Keuangan Bulan '.$namaBulan[$bulan],
            'date'      => date('m/d/Y'),
            'transaksi' => $transaksi
        ];
        
        $pdf = PDF::loadView('uangmasuk', $data);
    
        return $pdf->download('Keuangan.pdf');
        
        return response()->json([
            'message'       => 'Laporan Keuangan Bulan Ini'
        ], 200);    
    }

}
