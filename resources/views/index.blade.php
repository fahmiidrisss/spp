<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 7 PDF Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-3">Laravel HTML to PDF Example</h2>

        <div class="d-flex justify-content-end mb-4">
            <a class="btn btn-primary" href="{{ URL::to('/transaksi/pdf') }}">Export to PDF</a>
        </div>

        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-danger">
                    <th scope="col">No.</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Nama Santri</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Total Transaksi</th>
                    <th scope="col">Status Transaksi</th>
                    <th scope="col">Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi ?? '' as $data)
                <tr>
                    <th scope="row">{{ $data->id_transaksi }}</th>
                    <td>{{ $data->nis }}</td>
                    <td>{{ $data->nama_santri }}</td>
                    <td>{{ $data->kelas }}</td>
                    <td>{{ $data->total_bayar }}</td>
                    <td>{{ $data->status_transaksi }}</td>
                    <td>{{ $data->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>

</html>