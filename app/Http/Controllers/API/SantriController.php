<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SantrisImport;
use App\Imports\UsersImport;

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

        $user = Santri::where('nis', $request->nis)->first();
        if($user != null)
        {
            return response()->json([
                'message' => 'NIS telah digunakan'
            ], 400);
        } 

        $user = new User;
        $user->username = $request->nis;
        $user->role = "Santri";
        $user->password = Hash::make($request->nis."123");
        $user->save();
        
        
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
        $santri->id_user = $user->id_user;
        $santri->save();

        return response()->json([
            'message' => 'Data Santri Berhasil Ditambahkan',
            'data_santri' => $santri
        ], 200);
    }

    public function getSantri()
    {
        // $santri = Santri::all();
        $santri = DB::table('santris')
            ->join('kelas', 'santris.id_kelas', '=', 'kelas.id_kelas')
            ->select('santris.nis', 'santris.nama_santri', 'kelas.nama_kelas', 'santris.subsidi', 'santris.jumlah_tunggakan')
            ->get();

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
        $santri = Santri::find($nis);
        $user = User::where('username', $santri->nis)->delete();
        $santri->delete();

        return response()->json([
            'message' => 'Data Santri Berhasil Dihapus'
        ], 200);
    }

    public function detailSantri($nis)
    {
        $santri = DB::table('santris')
            ->join('kelas', 'santris.id_kelas', '=', 'kelas.id_kelas')
            ->select('santris.nis', 'santris.nama_santri','kelas.nama_kelas', 'santris.tanggal_lahir', 
            'santris.alamat', 'santris.no_hp', 'santris.jenis_kelamin', 'santris.nama_wali', 'santris.subsidi', 
            'santris.jumlah_tunggakan')
            ->where('nis', $nis)
            ->get();

        if($santri == null)
        {
            return response()->json([
                'message'   => 'Santri tidak ditemukan'
            ], 400);    
        }
        return response()->json([
            'message'   => 'Detail Santri Berhasil Ditampilkan',
            'santri'    => $santri[0]
        ], 200);
    }

    public function cekStatusSPP($nis)
    {
        $santri = Santri::find($nis);
        
        if($santri->jumlah_tunggakan > 0)
        {
            return response()->json([
                'message'   => 'SPP Bulan ini Belum Lunas',
                'status'    => 0,
                'tunggakan' => $santri->jumlah_tunggakan
            ], 200);
        }
        
        return response()->json([
            'message'   => 'SPP Bulan ini Lunas',
            'status'    => 1,
            'tunggakan' => 0
        ], 200);
    }

    public function updatePassword(Request $request, $nis)
    {
        $santri = User::where('username', $nis)->first();

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => Password::min(8)
        ]);

        if(!\Hash::check($request->password_lama, $santri->password))
        {
            return response()->json([
                'message' => 'Password Lama Tidak Sesuai'
            ], 401);
        }
        
        // $santri->update([
        //     'password'  => Hash::make($request->password)
        // ]);
        $santri->password = Hash::make($request->password_baru);
        $santri->save();

        return response()->json([
            'message'   => 'Password Santri Berhasil Diubah'
        ], 200);
    }

    public function searchSantri($nama)
    {
        $santri = DB::table('santris')
            ->join('kelas', 'santris.id_kelas', '=', 'kelas.id_kelas')
            ->select('santris.nis', 'santris.nama_santri', 'kelas.nama_kelas', 'santris.subsidi', 'santris.jumlah_tunggakan')
            ->where('nama_santri', 'like', '%'.$nama.'%')
            ->get();
        
        if($santri == null)
        {
            return response()->json([
                'message'   => 'Santri Tidak Ditemukan'
            ], 404);
        } else if($santri != null)
        {
            return response()->json([
                'message'   => 'Hasil Pencarian',
                'santri'    => $santri
            ], 200);
        }
    }

    public function createSantriExcel(Request $request)
    {
        Excel::import(new SantrisImport, $request->file('file')->store('temp'));
        Excel::import(new UsersImport, $request->file('file')->store('temp'));
        
        // return back();

        $santri = Santri::where('id_user', null)->get();
        $jumlah = count($santri);
        for($i = 0; $i < $jumlah; $i++)
        {
            $user = User::where('username', $santri[$i]->nis)->first();
            $id = Santri::where('nis', $santri[$i]->nis)->first();
            $id->id_user = $user->id_user;
            $id->save();
        }

        return response()->json([
            'message'   => 'Upload Data Santri Berhasil',
            'santri'    => $santri
        ], 200);
    }
}
