<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
            return response()->json([
                'message'   => 'Authorized',
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
        } else if($user->role == Operator) 
        {
            return response()->json([
                'message'   => 'Authorized',
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

    public function tesWeb()
    {
        return "tes Web";
    }

    public function tesApi()
    {
        return "ini tes API";
    }
}
