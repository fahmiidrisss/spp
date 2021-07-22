<!DOCTYPE html>
<html>
@php
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\LaporanController;
@endphp

<head>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        h1,
        h4 {
            text-align: center;
        }

        .data {
            display: block;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        hr.solid {
            border-top: 3px solid #bbb;
        }

        .grid-container {
            display: inline-grid;
            grid-template-columns: auto auto auto;
        }
    </style>

    <h1>MADRASAH DINIYYAH MUBAROKULHUDA</h1>
    <h4>Jl. Raya Kamasan Banjaran No.243, Kamasan, Kec. Banjaran, Bandung, Jawa Barat 40377 Telp: (022)25940050</h4>
</head>

<hr class="solid">

<body>
    <div class="data">
        {{-- <h3>{{ $title }}</h3> --}}
        {{-- <h3>TANGGAL {{$TIMESTAMP}}</h3> --}}
        {{-- <h3>TAHUN {{$tahun}}</h3> --}}
        <p style="text-align:left;">
            Nomor : 01/KU/PPAM/V/2021<br>
            Sifat : Penting<br>
            Lampiran : –<br>
            Perihal : Pemberitahuan<br>
        </p>
        <p style="text-align:left;">
            Kepada<br>
            Yth. BapakIbu/Wali Santri<br>
            di tempat<br>
        </p>
        <p style="text-align:left;">
            Assalamu’alaikum Wr.Wb.<br>

            Segala puji bagi ALLAH SWT yang telah memperlihatkan rahmat taufiq dan hidayah-Nya kepada kita, sholawat serta salam agar tetap terlimpahkan kepada Nabi Muhammad saw, beserta keluarga, sahabat dan pengikutnya.

            Berdasarkan catatan keuangan pondok pesantren kami beritahukan bahwa santri berikut :<br><br>

            NIS     : {{$nis}}<br>
            Nama    : {{$nama}}<br>
            Kelas   : {{$kelas}}<br><br>

            Mempunyai tanggungan sebagai berikut :<br>

            SPP {{$jumlah_tunggakan}} Bulan, Tahun {{$tahun}}<br>
            JUMLAH : {{$nominal_tunggakan}}<br><br>
            Demikian surat pemberitahuan kami sampaikan, atas perhatiannya diucapkan terima kasih.<br>

            Wassalamualaikum wr.wb.<br><br>
        </p>
        <p style="text-align:right;">
            
            Bandung, {{$tanggal}}<br>
            Pimpinan,<br><br><br>

            Kepala Sekolah<br>

        </p>
    </div>
</body>

</html>