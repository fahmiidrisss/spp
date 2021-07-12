<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use PDF;

class LaporanController extends Controller 
{

    public function showTransaksi(){
      $transaksi = Transaksi::all();
      return view('index', compact('transaksi'));
    }

    // Generate PDF
    public function getLaporanUangMasuk(Request $request) {

      // share data to view
      $pdf = PDF::loadView('pdf_view', $request);

      // download PDF file with download method
      return $pdf->download('pdf_file.pdf');
    }
}