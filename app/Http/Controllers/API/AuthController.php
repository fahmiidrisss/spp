<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();
    
        if(!$user || !\Hash::check($request->password, $user->password))
        {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        if($user->role == 'Admin')
        {
            $admin = Admin::where('username', $request->username)->first();
            return response()->json([
                'message'   => 'Authorized',
                'id_admin'  => $admin->id_admin,
                'username'  => $user->username,
                'token'     => $token,
                'role'      => $user->role,
                'list_menu' => [
                    'dashboard',
                    'akun',
                    'admin',
                    'santri',
                    'input_transaksi',
                    'riwayat_transaksi',
                    'laporan'
                ]
            ], 200);
        } else if($user->role == 'Operator') 
        {
            $admin = Admin::where('username', $request->username)->first();
            return response()->json([
                'message'   => 'Authorized',
                'id_admin'  => $admin->id_admin,
                'username'  => $user->username,
                'token'     => $token,
                'role'      => $user->role,
                'list_menu' => [
                    'dashboard',
                    'input_transaksi'
                    ]
            ], 200);
        }
        
        return response()->json([
            'message'   => 'Authorized',
            'username'  => $user->username,
            'token'     => $token,
            'role'      => $user->role,
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil Logout'
        ], 200);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'username'  => 'required',
            'role'      => 'required',
            'password'  => Password::min(8)
        ]);

        $user = new User;
        $user->username = $request->username; 
        $user->role = $request->role;
        $user->password = Hash::make($request->password); 
        $user->save();
        
        return response()->json([
            'message'   => 'User Berhasil Ditambahkan',
            'user'      => $user
        ], 200);
    }

    public function deleteUser($id)
    {
        $user = User::find($id)->delete();

        return response()->json([
            'message' => 'User Berhasil Dihapus'
        ], 200);
    }
}
