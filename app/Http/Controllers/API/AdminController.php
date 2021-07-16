<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class AdminController extends Controller
{
    public function createAdmin(Request $request)
    {
        $request->validate([
            'username'  => 'required',
            'nama_admin'=> 'required',
            'role'      => 'required',
            'paraf'     => 'required',
            'password'  => Password::min(8)   
        ]);

        $user = new User;
        $user->username = $request->username; 
        $user->role = $request->role;
        $user->password = Hash::make($request->password); 
        $user->save();
        // dd($request->all());
        $admin = new Admin;
        $admin->username = $request->username;
        $admin->nama_admin = $request->nama_admin;
        $admin->role = $request->role;
        $admin->paraf = $request->paraf;
        $admin->id_user = $user->id_user;
        $admin->save();

        return response()->json([
            'message'   => 'Data Admin Berhasil Ditambahkan',
            'data_admin'=> $admin,
            'user'      => $user
        ], 200);
    }

    public function getAdmin()
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
        $user = User::where('username', $admin->username);

        $request->validate([
            'username'  => 'required',
            'nama_admin'=> 'required',
            'role'      => 'required',
            'paraf'     => 'required'    
        ]);

        $admin->update([
            'username'  => $request->username,
            'nama_admin'=> $request->nama_admin,
            'role'      => $request->role,
            'paraf'     => $request->paraf
        ]);

        
        $user->update([
            'username'  => $request->username,
            'role'      => $request->role
        ]);
        return response()->json([
            'message' => 'Data Admin Berhasil Diubah',
            'data_admin' => $admin
        ], 200);
    }

    public function deleteAdmin($id)
    {
        $admin = Admin::find($id);
        $user = User::where('username', $admin->username)->delete();
        $admin->delete();

        return response()->json([
            'message' => 'Data Admin Berhasil Dihapus'
        ], 200);
    }

    public function detailAdmin($id)
    {
        $admin = Admin::find($id);

        return response()->json([
            'message'   => 'Detail Admin Berhasil Ditampilkan',
            'admin'    => $admin
        ], 200);
    }
}
