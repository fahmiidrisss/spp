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

        return response()->json([
            'message'   => 'Authorized',
            'user'      => $user,
            'token'     => $token,
            'role'      => $user->role
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
