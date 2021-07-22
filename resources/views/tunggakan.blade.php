<!DOCTYPE html>
<html>

<head>
    <h1>{{ $title }}</h1>
</head>
<table class="table table-bordered mb-5">
    <thead>
        <tr class="table-danger">
            <th scope="col">No.</th>
            <th scope="col">NIS</th>
            <th scope="col">Nama Santri</th>
            <th scope="col">Kelas</th>
            <th scope="col">Jumlah Tunggakan</th>
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
            <td><center>{{ $no = $no+1 }}</center></td>
            <td><center>{{ $data->nis }}</center></td>
            <td>{{ $data->nama_santri }}</td>
            <td><center>{{ $data->nama_kelas }}</center></td>
            <td><center>{{ $data->jumlah_tunggakan }}</center></td>
            <td><center>{{ $data->jumlah_tunggakan*50000 }}</center></td>
        </tr>
        {{$total_uang = $total_uang+$data->jumlah_tunggakan*50000}}
        @endforeach
        <br>
        <tr>
            <td><b>Total Tunggakan: Rp. {{$total_uang}}<b></td>
        </tr>
    </tbody>
</table>
</html>