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
        <h3>{{ $title }}</h3>
        {{-- <h3>TANGGAL {{$TIMESTAMP}}</h3> --}}
        <h3>TAHUN {{$tahun}}</h3>
        <table class="table table-bordered mb-5" style="margin-left:auto;margin-right:auto;text-align:center">
            <thead>
                <tr class="table-danger" style="border: 1px solid black">
                    <th scope="col">No.</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Nama Santri</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Jumlah Tunggakan</th>
                    <th scope="col">Tahun</th>
                    <th scope="col">Nominal Tunggakan</th>
                </tr>
            </thead>
            <tbody>

                @php
                $no = 0;
                $total_uang = 0;
                @endphp
                @foreach($tunggakan ?? '' as $data)
                <tr>
                    <td>
                        <center>{{ $no = $no+1 }}</center>
                    </td>
                    <td>
                        <center>{{ $data->nis }}</center>
                    </td>
                    <td>{{ $data->nama_santri }}</td>
                    <td>
                        <center>{{ $data->nama_kelas }}</center>
                    </td>
                    <td>
                        <center>{{ $data->jumlah_tunggakan }}</center>
                    </td>
                    <td><center>{{ $tahun }}</center></td>
                    <td>
                        <center>{{ LaporanController::rupiah($data->jumlah_tunggakan*50000) }}</center>
                    </td>
                </tr>
                {{$total_uang = $total_uang+$data->jumlah_tunggakan*50000}}
                @endforeach
                <br>
                <tr>
                    <td><b>Total Tunggakan: {{LaporanController::rupiah($total_uang)}}<b></td>
                </tr>
            </tbody>
        </table>
    </div>
    {{-- <p>Mengetahui,</p> --}}
    <div class="grid-container">
        <div class="grid-item " style="margin-right: 700px;">
            <p>Kepala Madrasah</p>
            <br>
            <br>
            <p>_____________________</p>
            <p>NIP:__________________</p>
        </div>
        <div class=" grid-item ">
            <p>Bendahara Sekolah</p>
            <br>
            <br>
            <p>_____________________</p>
            <p>NIP:__________________</p>
        </div>
    </div>
</body>

</html>