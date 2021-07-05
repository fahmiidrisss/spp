<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use PDF;

class LaporanController extends Controller 
{
    // Generate PDF
    public function createPDF() {
      // retreive all records from db
      $data = Transaksi::all();

      // share data to view
      view()->share('employee',$data);
      $pdf = PDF::loadView('pdf_view', $data);

      // download PDF file with download method
      return $pdf->download('pdf_file.pdf');
    }
}