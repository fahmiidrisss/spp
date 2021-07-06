<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kode;


class TransferController extends Controller
{
    public function getKode()
    {
        $kode = Kode::where('status_kode', 0)->first();
        $kode->update(['status_kode' => 1]);

        return response()->json([
            'message'   => 'Kode Unik Berhasil Digenerate',
            'kode_unik' => $kode
        ], 200);
    }
}
