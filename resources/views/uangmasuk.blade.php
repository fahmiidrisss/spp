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
            <th scope="col">Total Transaksi</th>
            <th scope="col">Status Transaksi</th>
            {{-- <th scope="col">Tanggal Transaksi</th> --}}
        </tr>
    </thead>
    <tbody>
        
        @php
        $no = 0;
        $total_uang = 0;
        @endphp
        @foreach($transaksi ?? '' as $data)
        <tr>
            {{-- <th scope="row">{{ $data->id_transaksi }}</th> --}}
            <td><center>{{ $no = $no+1 }}</center></td>
            <td><center>{{ $data->nis }}</center></td>
            <td>{{ $data->nama_santri }}</td>
            <td><center>{{ $data->nama_kelas }}</center></td>
            <td><center>{{ $data->total_bayar }}</center></td>
            <td><center>{{ $data->status_transaksi }}</center></td>
            {{-- <td>{{ $data->created_at }}</td> --}}
        </tr>
        {{$total_uang = $total_uang+$data->total_bayar}}
        @endforeach
        <br>
        <tr>
            <td><b>Total Uang: Rp. <b>{{$total_uang}}</td>
        </tr>
    </tbody>
</table>
</html>