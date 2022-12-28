<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    
    
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.css"> -->
    <style>
        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }
        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }
        .mb-4{
            margin-bottom: 1.5rem !important;
        }
        table {
           border-collapse: collapse;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
        .table th,
        .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        }

        .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
        }

        .table tbody + tbody {
        border-top: 2px solid #dee2e6;
        }

        .table-sm th,
        .table-sm td {
        padding: 0.3rem;
        }

        .table-bordered {
        border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
        border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
        border-bottom-width: 2px;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1.25rem;
        }
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6 !important;
        }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }
        
    </style>

</head>

<body >

<div class="card mb-4">
        <div class="card-body">
            
                <table class="table table-striped table-bordered " >
                    <thead>
                        <tr>
                            <th >No.</th>
                            <th >Nama Karyawan</th>
                            <th >Email</th>
                            <th >No Hp</th>
                            <th >Pangkat Karyawan</th>
                            <th >Perusahaan</th>
                            <th >Jenis Kelamin</th>
                            <th >Alamat</th>
                            <th >Tanggal Lahir</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($karyawan as $k)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{$k->nama_karyawan}}</td>
                            <th>{{$k->email}}</th>
                            <th>{{$k->no_hp}}</th>
                            <th>{{$k->nama_pangkat}}</th>
                            <th>{{$k->nama_perusahaan}}</th>
                            @if($k->jenis_kelamin == "L")
                            <th>Laki Laki</th>
                            @elseif($k->jenis_kelamin == "P")
                            <th>Perempuan</th>
                            @endif
                            <th>{{$k->alamat}}</th>
                            <th>{{$k->tanggal_lahir}}</th>
                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            
        </div>
</div>

</body>

</html>
