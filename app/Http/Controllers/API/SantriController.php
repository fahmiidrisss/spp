<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Santri;
use App\Models\Kelas;

class SantriController extends Controller
{
    public function createSantri(Request $request)
    {
        $request->validate([
            'nis'               => 'required',
            'nama_santri'       => 'required',
            'tanggal_lahir'     => 'required',
            'alamat'            => 'required',
            'no_hp'             => 'required',
            'nama_wali'         => 'required',
            'jenis_kelamin'     => 'required',
            'subsidi'           => 'required',
            'jumlah_tunggakan'  => 'required',
            'nama_kelas'        => 'required'
        ]);
        // $santri = Kelas::select('id_kelas')->where('nama_kelas', $request->nama_kelas);

        // dd($request->all());
        // dd($santri);
        $santri = new Santri;
        $santri->nis = $request->nis;
        $santri->nama_santri = $request->nama_santri;
        $santri->tanggal_lahir = $request->tanggal_lahir;
        $santri->alamat = $request->alamat;
        $santri->no_hp = $request->no_hp;
        $santri->nama_wali = $request->nama_wali;
        $santri->jenis_kelamin = $request->jenis_kelamin;
        $santri->subsidi = $request->subsidi;
        $santri->jumlah_tunggakan = $request->jumlah_tunggakan;
        $id_kelas = DB::table('kelas')->select('id_kelas')->where('nama_kelas', $request->nama_kelas)->first();
        $santri->id_kelas = $id_kelas->id_kelas;
        $santri->save();

        return response()->json([
            'message' => 'Data Santri Berhasil Ditambahkan',
            'data_santri' => $santri
        ], 200);
    }

    public function showSantri()
    {
        $santri = Santri::all();

        return response()->json(array(
            'status' => 'success',
            'santri' => $santri->toArray()),
            200
        );
    }

    public function updateSantri(Request $request, $id)
    {
        $santri = Santri::find($id);
        
        $request->validate([
            'nis'               => 'required',
            'nama_santri'       => 'required',
            'tanggal_lahir'     => 'required',
            'alamat'            => 'required',
            'no_hp'             => 'required',
            'nama_wali'         => 'required',
            'jenis_kelamin'     => 'required',
            'subsidi'           => 'required',
            'jumlah_tunggakan'  => 'required',
            'nama_kelas'        => 'required'    
        ]);

        $id_kelas = DB::table('kelas')->select('id_kelas')->where('nama_kelas', $request->nama_kelas)->first();
        $request->nama_kelas = $id_kelas->id_kelas;

        $santri->update([
            'nis'               => $request->nis,
            'nama_santri'       => $request->nama_santri,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'alamat'            => $request->alamat,
            'no_hp'             => $request->no_hp,
            'nama_wali'         => $request->nama_wali,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'subsidi'           => $request->subsidi,
            'jumlah_tunggakan'  => $request->jumlah_tunggakan,
            'id_kelas'          => $request->nama_kelas
        ]);

        return response()->json([
            'message' => 'Data Santri Berhasil Diubah',
            'data_santri' => $santri
        ], 200);
    }

    public function deleteSantri($nis)
    {
        $santri = Santri::find($nis)->delete();

        return response()->json([
            'message' => 'Data Santri Berhasil Dihapus'
        ], 200);
    }
}
