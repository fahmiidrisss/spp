<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class TransaksiController extends Controller
{
    public function try()
    {
        return response()->json([
            'message' => 'Tes Route'
        ], 200);
    }

    public function createTransaksi(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        $tanggal_sekarang = date("Y-m-d", strtotime("now"));
        $waktu_sekarang = date("Y-m-d H:i", strtotime("now"));
        $waktu = Carbon::now();

        $request->validate([
            'nis'               => 'required',
            'jumlah_bulan'      => 'required',
            'total_bayar'       => 'required',
            'spp'               => 'required',
            'infaq'             => 'required',
            'id_admin'          => 'required'
        ]);

        $santri = Santri::where('nis', $request->nis)->first();
        if(!$santri)
        {
            return response()->json([
                'message' => 'NIS tidak terdaftar'
            ], 404);
        }
        
        $maks_bayar = Tahunajaran::sum('jumlah_bulan');
        $transaksi = Transaksi::where('nis', $request->nis)->get();
        $total_transaksi = count($transaksi);
        $maks_transaksi = $maks_bayar-$total_transaksi;
        $tahun_ajaran = Tahunajaran::where('jumlah_bulan', '=', 12)->orderBy('id_tahun', 'desc')->first();

        if($maks_bayar == $total_transaksi)
        {
            return response()->json([
                'message'   => 'SPP Anda Tahun Ini Sudah Lunas, Tunggu Tahun Ajaran Berikutnya'
            ], 200);    
        } 

        if($request->jumlah_bulan > $maks_transaksi)
        {
            return response()->json([
                'message'   => 'Anda Hanya Bisa Membayar SPP Maksimal sebanyak '.$maks_transaksi.' Bulan, Silahkan Input Ulang',
            ], 200); 
        }

        for($i = 0; $i < $request->jumlah_bulan; $i++)
        {
            $transaksi = Transaksi::where('nis', $request->nis)->orderBy('id_transaksi', 'desc')->first();
            if($transaksi == null)
            {
                $bulan = env("AWAL_BULAN_AJARAN", 7);
                $tahun = $tahun_ajaran->id_tahun;
            } else if($transaksi != null && $transaksi->bulan < 12 )
            {
                $bulan = $transaksi->bulan+1;
                $tahun = $tahun_ajaran->id_tahun;
            } else if($transaksi != null && $transaksi->bulan >= 12)
            {
                    $bulan = 1;
                    $tahun = $tahun_ajaran->id_tahun;
            }

            $transaksi = new Transaksi();
            $transaksi->nis = $request->nis;
            $transaksi->total_bayar = 50000;
            $transaksi->spp = 35000;
            $transaksi->infaq = 15000;
            $transaksi->bulan = $bulan;
            $transaksi->id_tahun = $tahun;
            $transaksi->status_transaksi = "Tunai";
            $transaksi->id_admin = $request->id_admin;
            $transaksi->tanggal_transaksi = $tanggal_sekarang;
            $transaksi->save();
            // dd($transaksi);
        }

        $tunggakan = $santri->jumlah_tunggakan-$request->jumlah_bulan;
        $santri->update(['jumlah_tunggakan' => $tunggakan]);

        $total_transaksi = 50000*$request->jumlah_bulan;

        return response()->json([
            'message'           => 'Transaksi Berhasil',
            'id_transaksi'      => $transaksi->id_transaksi,
            'nis'               => $transaksi->nis,
            'total_bayar'       => $total_transaksi,
            'status_transaksi'  => $transaksi->status_transaksi,
            'tanggal_transaksi' => $transaksi->tanggal_transaksi,
            'admin'             => $transaksi->id_admin
            // 'transaksi' => $transaksi
        ], 200);
    }

    public function getUangBulanan()
    {
        $waktu = Carbon::now();
        $tahun_ajaran = Tahunajaran::where('jumlah_bulan', '=', 12)->orderBy('id_tahun', 'desc')->first();
        $uang = Transaksi::selectRaw('bulan, sum(total_bayar) as total')
            ->groupBy('bulan')
            ->where('id_tahun', $tahun_ajaran->id_tahun)
            ->get();

        return response()->json([
            'message'       => 'Uang Masuk Pembayaran SPP per Bulan',
            'uang_masuk'    => $uang
        ], 200);
    }

    public function getTotalBulanan()
    {
        $waktu = Carbon::now();
        $uang = Transaksi::whereMonth('tanggal_transaksi', $waktu->month)
            ->whereYear('tanggal_transaksi', $waktu->year)
            ->sum('total_bayar');

        return response()->json([
            'message'       => 'Total Uang Masuk Bulan Ini',
            'uang_masuk'    => $uang
        ], 200);
    }

    public function getTotalHarian()
    {
        $waktu = Carbon::now();
        $uang = Transaksi::whereDay('tanggal_transaksi', $waktu->day)
            ->whereMonth('tanggal_transaksi', $waktu->month)
            ->whereYear('tanggal_transaksi', $waktu->year)
            ->sum('total_bayar');

        // $total = $uang*2;

        return response()->json([
            'message'       => 'Total Uang Masuk Hari Ini',
            'uang_masuk'    => $uang
        ], 200);
    }

    public function getSantriBayar()
    {
        $waktu = Carbon::now();
        $santri = Transaksi::whereMonth('tanggal_transaksi', $waktu->month)
            ->groupBy('nis')
            ->select('nis', DB::raw('count(nis) as total'))
            ->get();
        
        return response()->json([
            'message'       => 'Jumlah Santri yang Bayar Bulan Ini',
            'santri'        => count($santri)
        ], 200);
    }

    public function getSantriTunggakan()
    {
        $santri = Santri::where('jumlah_tunggakan', '>', 0)->get();
        
        return response()->json([
            'message'       => 'Jumlah Santri yang Menunggak Bulan Ini',
            'santri'        => count($santri)
        ], 200);
    }

    public function getTransaksi()
    {
        $transaksi = DB::table('transaksis')
        ->join('santris', 'transaksis.nis', '=', 'santris.nis')
        ->select('transaksis.id_transaksi', 'transaksis.tanggal_transaksi', 
        'santris.nama_santri', 'transaksis.total_bayar', 'transaksis.status_transaksi')
        ->orderBy('transaksis.id_transaksi', 'desc')
        ->get();

        return response()->json(array(
            'message' => 'Riwayat Transaksi Berhasil Ditampilkan',
            'transaksi' => $transaksi),
            200
        );
    }

    public function getTransaksiSantri($nis)
    {
        $transaksi = DB::table('transaksis')
            ->join('admins', 'transaksis.id_admin', '=', 'admins.id_admin')
            ->select('transaksis.id_transaksi', 'transaksis.tanggal_transaksi', 'transaksis.bulan', 
            'transaksis.spp', 'transaksis.infaq', 'transaksis.total_bayar', 'admins.paraf', 'transaksis.status_transaksi')
            ->orderBy('transaksis.id_transaksi', 'desc')
            ->where('nis', $nis)
            ->get();

        return response()->json(array(
            'message' => 'Riwayat Pembayaran Berhasil Ditampilkan',
            'transaksi' => $transaksi->toArray()),
            200
        );
    }

    public function getKartuSantri($nis)
    {
        $tahun_ajaran = Tahunajaran::where('jumlah_bulan', '=', 12)->orderBy('id_tahun', 'desc')->first();
        
        $transaksi = DB::table('transaksis')
            ->join('admins', 'transaksis.id_admin', '=', 'admins.id_admin')
            ->join('tahunajarans', 'transaksis.id_tahun', '=', 'tahunajarans.id_tahun')
            ->select('transaksis.id_transaksi', 'transaksis.tanggal_transaksi', 'transaksis.bulan', 
            'transaksis.spp', 'transaksis.infaq', 'transaksis.total_bayar', 'admins.paraf')
            ->where('transaksis.nis', $nis)
            ->where('transaksis.id_tahun', $tahun_ajaran->id_tahun)
            ->get();

            return response()->json(array(
                'message' => 'Kartu SPP Berhasil Ditampilkan',
                'transaksi' => $transaksi->toArray()),
                200
            );
    }

    public function tesTahun(Request $request)
    {
        $maks_bayar = Tahunajaran::sum('jumlah_bulan');
        $transaksi = Transaksi::where('nis', $request->nis)->get();
        $total_transaksi = count($transaksi);
        $maks_transaksi = $maks_bayar-$total_transaksi;

        if($maks_bayar == $total_transaksi)
        {
            return response()->json([
                'message'   => 'SPP Anda Tahun Ini Sudah Lunas, Tunggu Tahun Ajaran Berikutnya'
            ], 200);    
        } 

        if($request->jumlah_bulan > $maks_transaksi)
        {
            return response()->json([
                'message'   => 'Anda Hanya Bisa Membayar SPP Maksimal sebanyak '.$maks_transaksi.' Bulan, Silahkan Input Ulang',
            ], 200); 
        }
        return response()->json([
            'max'   => $maks_transaksi
        ], 200);
    }
}
