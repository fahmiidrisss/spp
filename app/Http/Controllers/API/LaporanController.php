<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function getLaporanUangMasuk()
    {
        return response()->json([
            'message'   => 'Tes API Laporan'
        ], 200);
    }

    public function getLaporan()
    {
        return response()->json([
            'message'   => 'API Get Laporan'
        ], 200);
    }
}
