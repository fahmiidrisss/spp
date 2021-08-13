<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Tahunajaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanController extends Controller
{
    public static function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
        return $hasil_rupiah;
    }

    public function getLaporanUangMasuk($bulan)
    {
        $waktu = Carbon::now();
        $tahun_ajaran = Tahunajaran::where('tahun_ajaran', $waktu->year)->first();

        $transaksi = DB::table('transaksis')
            ->join('santris', 'transaksis.nis', '=', 'santris.nis')
            ->join('kelas', 'santris.id_kelas', '=', 'kelas.id_kelas')
            ->select('transaksis.id_transaksi', 'transaksis.tanggal_transaksi', 'transaksis.nis', 
            'santris.nama_santri', 'kelas.nama_kelas', 'transaksis.total_bayar', 
            'transaksis.status_transaksi')
            ->where([
                ['bulan', '=', $bulan],
                ['id_tahun', '=', $tahun_ajaran->id_tahun]
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
        $tahun_ajaran = Tahunajaran::where('jumlah_bulan', '=', 12)->orderBy('id_tahun', 'desc')->first();
        $tunggakan = DB::table('santris')
            ->join('kelas', 'santris.id_kelas', '=', 'kelas.id_kelas')
            ->select('santris.nis', 'santris.nama_santri', 'kelas.nama_kelas', 'santris.jumlah_tunggakan')
            ->where('jumlah_tunggakan', '>', 0)
            ->get();

        $data_tunggakan = [];
        foreach($tunggakan as $data)
        {
            $temp = [
                'nis'               => $data->nis,
                'nama_santri'       => $data->nama_santri,
                'nama_kelas'        => $data->nama_kelas,
                'jumlah_tunggakan'  => $data->jumlah_tunggakan,
                'tahun'             => $tahun_ajaran->tahun_ajaran,
                'nominal_tunggakan' => self::rupiah($data->jumlah_tunggakan*50000)
            ];
            array_push($data_tunggakan, $temp);
        }
        
        
        $jumlah_santri = count($tunggakan);
        
        return response()->json(array(
            'message'       => 'Laporan Tunggakan Santri',
            'jumlah_santri' => $jumlah_santri,
            'tunggakan'     => $data_tunggakan),
            200
        );    
    }

    public function unduhLaporanUangMasuk($bulan)
    {
        $waktu = Carbon::now();
        $tahun_ajaran = Tahunajaran::where('tahun_ajaran', '=', $waktu->year)->first();
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
                ['id_tahun', '=', $tahun_ajaran->id_tahun]
            ])
            ->get();
        $data = [
            'title'     => 'Laporan Keuangan Bulan '.$namaBulan[$bulan],
            'tahun'     => $tahun_ajaran->tahun_ajaran,
            'transaksi' => $transaksi
        ];
        
        $pdf = PDF::loadView('uangmasuk', $data);
    
        return $pdf->download('Keuangan.pdf');
        
        return response()->json([
            'message'       => 'Laporan Keuangan Bulan Ini'
        ], 200);    
    }

    public function unduhLaporanTunggakan()
    {
        $tahun_ajaran = Tahunajaran::where('jumlah_bulan', '=', 12)->orderBy('id_tahun', 'desc')->first();
        $tunggakan = DB::table('santris')
        ->join('kelas', 'santris.id_kelas', '=', 'kelas.id_kelas')
        ->select('santris.nis', 'santris.nama_santri', 'kelas.nama_kelas', 'santris.jumlah_tunggakan')
        ->where('jumlah_tunggakan', '>', 0)
        ->get();

        $data = [
            'title'     => 'Laporan Tunggakan SPP',
            'tahun'      => $tahun_ajaran->tahun_ajaran,
            'tunggakan' => $tunggakan
        ];

        $pdf = PDF::loadView('tunggakan', $data);
    
        return $pdf->download('Tunggakan.pdf');
        
        return response()->json([
            'message'       => 'Laporan Tunggakan SPP'
        ], 200);    
    }

    public function unduhLaporanTagihan($nis)
    {
        $tahun_ajaran = Tahunajaran::where('jumlah_bulan', '=', 12)->orderBy('id_tahun', 'desc')->first();
        $tanggal = Carbon::now()->format('d F Y');
        
        $tunggakan = DB::table('santris')
            ->join('kelas', 'santris.id_kelas', '=', 'kelas.id_kelas')
            ->select('santris.nis', 'santris.nama_santri', 'kelas.nama_kelas', 'santris.jumlah_tunggakan')
            ->where('nis', '=', $nis)
            ->get();

        $data = [
            'title'     => 'Surat Tagihan SPP',
            'nis'       => $tunggakan[0]->nis,
            'nama'      => $tunggakan[0]->nama_santri,
            'kelas'     => $tunggakan[0]->nama_kelas,
            'jumlah_tunggakan'  => $tunggakan[0]->jumlah_tunggakan,
            'tahun'      => $tahun_ajaran->tahun_ajaran,
            'nominal_tunggakan' => self::rupiah($tunggakan[0]->jumlah_tunggakan*50000),
            'tanggal'   => $tanggal
        ];

        $pdf = PDF::loadView('tagihan', $data);
    
        return $pdf->download('Tagihan'.$nis.'pdf');
        
        return response()->json([
            'message'       => 'Surat Tagihan SPP'
        ], 200);   
    }
}
