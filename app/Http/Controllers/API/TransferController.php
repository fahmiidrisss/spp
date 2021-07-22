<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kode;
use App\Models\Tahunajaran;
use App\Models\Santri;
use App\Models\Transfer;
use App\Models\Transaksi;
use Carbon\Carbon;

class TransferController extends Controller
{
    public static function getKode()
    {
        $kode = Kode::where('status_kode', 0)->first();
        $kode->update(['status_kode' => 1]);

        return $kode;
    }

    public function createTransfer(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        $jam_sekarang = date("H:i", strtotime("now"));
        $tanggal_sekarang = date("Y-m-d", strtotime("now"));
        $waktu_sekarang = date("Y-m-d H:i", strtotime("now"));

        $request->validate([
            'nis'               => 'required',
            'jumlah_bulan'      => 'required',
            'total_transfer'    => 'required',
            'spp'               => 'required',
            'infaq'             => 'required'
        ]);

        $santri = Santri::where('nis', $request->nis)->first();
        if(!$santri)
        {
            return response()->json([
                'message' => 'NIS tidak terdaftar'
            ], 401);
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

        $kode_transfer = self::getKode();

        // dd($request->all());
        $transfer = new Transfer();
        $transfer->nis = $request->nis;
        $transfer->total_transfer = 50000*$request->jumlah_bulan;
        $transfer->spp = ($transfer->total_transfer/100)*70;
        $transfer->infaq = ($transfer->total_transfer/100)*30;
        $transfer->status_transfer = "Transfer";
        $transfer->id_kode = $kode_transfer->id_kode;
        $transfer->tanggal_transfer = $tanggal_sekarang;
        $transfer->save();
        
        return response()->json([
            'message'           => 'Transfer Berhasil',
            'kode_transfer'      => $kode_transfer->kode_unik
        ], 200);
    }

    public function getTransfer()
    {
        $transfer = Transfer::all();

        return response()->json(array(
            'message' => 'Riwayat Transfer Berhasil Ditampilkan',
            'transfer' => $transfer->toArray()),
            200
        );
    }

    public function deleteTransfer(Request $request, $id)
    {
        $waktu = Carbon::now();
        $transfer = Transfer::find($id);
        $transaksi = $transfer;
        $tahun_ajaran = Tahunajaran::where('jumlah_bulan', '=', 12)->orderBy('id_tahun', 'desc')->first();

        $jumlah_bulan = ($transfer->total_transfer/50000);

        for($i = 0; $i < $jumlah_bulan; $i++)
        {
            $last_transaction = Transaksi::where('nis', $transfer->nis)->orderBy('id_transaksi', 'desc')->first();
            if($last_transaction == null)
            {
                $bulan = env("AWAL_BULAN_AJARAN", 7);
                $tahun = $tahun_ajaran->id_tahun;
            } else if($last_transaction != null && $last_transaction->bulan < 12 )
            {
                $bulan = $last_transaction->bulan+1;
                $tahun = $tahun_ajaran->id_tahun;
            } else if($last_transaction != null && $last_transaction->bulan >= 12)
            {
                    $bulan = 1;
                    $tahun = $tahun_ajaran->id_tahun;
            }

            $transaksi = new Transaksi();
            $transaksi->nis = $transfer->nis;
            $transaksi->total_bayar = 50000;
            $transaksi->spp = 35000;
            $transaksi->infaq = 15000;
            $transaksi->bulan = $bulan;
            $transaksi->id_tahun = $tahun;
            $transaksi->status_transaksi = "Transfer";
            $transaksi->id_admin = $request->id_admin;
            $transaksi->tanggal_transaksi = $transfer->tanggal_transfer;
            $transaksi->save();
        }

        $santri = Santri::where('nis', $transfer->nis)->first();
        $tunggakan = $santri->jumlah_tunggakan-$jumlah_bulan;
        $santri->update(['jumlah_tunggakan' => $tunggakan]);
        $total_transaksi = 50000*$jumlah_bulan;
        $transfer = Transfer::find($id)->delete();

        return response()->json([
            'message'           => 'Transaksi Berhasil',
            'id_transaksi'      => $transaksi->id_transaksi,
            'nis'               => $transaksi->nis,
            'total_bayar'       => $total_transaksi,
            'status_transaksi'  => $transaksi->status_transaksi,
            'tanggal_transaksi' => $transaksi->tanggal_transaksi,
            'admin'             => $transaksi->id_admin
        ], 200);
    }
}
