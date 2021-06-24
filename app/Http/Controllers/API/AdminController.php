<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function createAdmin(Request $request)
    {
        $request->validate([
            'username'  => 'required',
            'nama_admin'=> 'required',
            'role'      => 'required',
            'paraf'     => 'required'    
        ]);

        // dd($request->all());
        $admin = new Admin;
        $admin->username = $request->username;
        $admin->nama_admin = $request->nama_admin;
        $admin->role = $request->role;
        $admin->paraf = $request->paraf;
        $admin->save();

        return response()->json([
            'message' => 'Data Admin Berhasil Ditambahkan',
            'data_admin' => $admin
        ], 200);
    }

    public function showAdmin()
    {
        $admin = Admin::all();;

        return response()->json(array(
            'status' => 'success',
            'admin' => $admin->toArray()),
            200
        );
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::find($id);
        
        $request->validate([
            'username'  => 'required',
            'nama_admin'=> 'required',
            'role'      => 'required',
            'paraf'     => 'required'    
        ]);

        $admin->update([
            'username' => $request->username,
            'nama_admin'=> $request->nama_admin,
            'role'      => $request->role,
            'paraf'     => $request->paraf
        ]);

        return response()->json([
            'message' => 'Data Admin Berhasil Diubah',
            'data_admin' => $admin
        ], 200);
    }

    public function deleteAdmin($id)
    {
        $admin = Admin::find($id)->delete();

        return response()->json([
            'message' => 'Data Admin Berhasil Dihapus'
        ], 200);
    }

}
