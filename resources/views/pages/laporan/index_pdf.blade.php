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
        .judul-grafik {
            color: black;
            font-size: 1.3em;
            text-align: center;
            margin-top: 2em;
        }
        
    </style>

</head>

<body >
    <div class="card shadow mb-4">
        @if($id==2)
        <h3 class="judul-grafik">TABEL RANGKING KARYAWAN</h3>
        @else
        <h3 class="judul-grafik">TABEL RANGKING TEAM LEADER</h3>
        @endif
        <div class="card-body">
            
            <div class="table-responsive">
                
                <<table class="table table-striped table-bordered dataTable" id="dataTable">
                <thead>
                        
                        <tr>
                            <th rowspan="2" class="align-middle text-center text-capitalize">No.</th>
                            <th rowspan="2" class="align-middle text-center text-capitalize">nama karyawan</th>
                            <th rowspan="2" class="align-middle text-center text-capitalize">Pangkat</th>
                            <th rowspan="2" class="align-middle text-center text-capitalize">Perusahaan</th>
                            @foreach($kriteria as $k)
                                @php
                                    $coll = 0;
                                    $jum = 0;
                                @endphp
                                @foreach($subkriteria as $sk)
                                    @if($k->id_kriteria == $sk->id_kriteria)
                                        @php
                                        $coll =$k->id_kriteria;   
                                        $jum ++;
                                        @endphp
                                    @endif
                                @endforeach
                                @if($coll == $k->id_kriteria)
                                    <th class="align-middle text-center text-capitalize" colspan="{{$jum}}">{{$k->nama_kriteria}} ( {{$k->bobot_kriteria}} ) ({{$k->golongan}}) </th>
                                @else
                                    <th rowspan="2" class="align-middle text-center text-capitalize">{{$k->nama_kriteria}}</th>
                                @endif
                            @endforeach
                            <th rowspan="2" class="align-middle text-center text-capitalize">Nilai Akhir</th>
                        </tr>
                        <tr>
                            @foreach($kriteria as $k)
                                @foreach($subkriteria as $sk)
                                    @if($k->id_kriteria == $sk->id_kriteria)
                                        <th class="align-middle text-capitalize text-center" >{{$sk->nama_sub_kriteria}} </th>
                                    @endif
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($karyawan as $k)
                        <tr>
                            <th  class="align-middle text-center text-capitalize">{{ $loop->iteration }}.</th>
                            <th  class="align-middle text-center text-capitalize">{{$k->nama_karyawan}}</th>
                            <th  class="align-middle text-center text-capitalize">
                                @if($k->id_pangkat==1)
                                Team Leader
                                @else
                                Karyawan
                                @endif
                            </th>
                            <th  class="align-middle text-center text-capitalize">{{$k->nama_perusahaan}}</th>
                            @foreach($kriteria as $kr)
                                @php
                                    $coll = 0;
                                    $jum = 0;
                                @endphp
                                @foreach($subkriteria as $sk)
                                    @php
                                        $cek = 0;
                                    @endphp
                                    @if($kr->id_kriteria == $sk->id_kriteria)
                                        @foreach($nilai_sub_kriteria as $ns)
                                            @if($ns->id_karyawan == $k->id_karyawan AND $sk->id_sub_kriteria == $ns->id_sub_kriteria ) 
                                                <th class="align-middle text-center text-capitalize">{{number_format($ns->nilai_sub_kriteria*10,2)}}</th> 
                                                @php
                                                    $cek ++;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if($cek == 0)
                                            <th></th>
                                        @endif
                                        @php
                                            $coll =$kr->id_kriteria;   
                                            $jum ++;
                                        @endphp
                                    @endif
                                @endforeach
                                <!-- <th>aa</th> -->
                                @if($coll != $kr->id_kriteria )
                                    @php
                                        $cek = 0;
                                    @endphp
                                    @foreach($nilai_kriteria as $nk)
                                        @if($nk->id_karyawan == $k->id_karyawan AND $kr->id_kriteria == $nk->id_kriteria ) 
                                                @php
                                                    $cek ++;
                                                @endphp
                                            <th class="align-middle text-center text-capitalize">{{number_format($nk->nilai_kriteria*10,2)}}</th>     
                                        @endif
                                    @endforeach
                                    @if($cek == 0)
                                        <th></th>
                                    @endif
                                @endif
                            @endforeach
                            <th  class="align-middle text-center text-capitalize">{{number_format($k->bobot_akhir/10,2)}}</th>
                        </tr>
                        
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

    </body>

</html>
