@extends('layouts.default')
@section('title','Data user')

@section('content')
    <div class="card shadow mb-4">
        @if($id==2)
        <h3 class="judul-grafik">TABEL RANGKING KARYAWAN</h3>
        @else
        <h3 class="judul-grafik">TABEL RANGKING TEAM LEADER</h3>
        @endif
    
        <div class="d-flex justify-content-center">
        <form action="{{route('laporan.date_range')}}"method="post" >
            @csrf    
            <input type="hidden" value="{{$id}}" name="id">
            <div class="form-inline">
                
                <div class="mb-3 form-group">
                    <label for="inputPassword" class="col-sm-4 pr-0 pl-0  col-form-label">Tanggal Awal</label>
                    <div class="col-sm-8 input-group date pr-0 pl-0" id="min">
                        <input type="text"  name="form_date" class="form-control" value="{{$min}}" id="from_date" placeholder="Dari Tanggal ">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white"> 
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>            
                        <!-- <input type="text" class="form-control" id="max" name="max"> -->
                    </div>
                </div>
                <div class="mb-3 form-group" >
                    <label for="inputPassword" class="col-sm-4 pr-0 pl-0  col-form-label">Tanggal Akhir</label>
                    <div class="col-sm-8 input-group date pr-0 pl-0" id="max">
                        <input type="text"  name="to_date" class="form-control" value="{{$max}}" id="to_date" placeholder="Sampai Tanggal ">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white"> 
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>            
                        <!-- <input type="text" class="form-control" id="max" name="max"> -->
                    </div>
                </div>
                <div class="mb-3 form-group ml-2" >
                    <button type="submit" id="btn-seleksi" class="btn btn-success">cari</button>
                </div>
                
            </div>
            </form>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                
                <table class="table table-striped table-bordered dataTable" id="dataTable">
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
                            <th  class="align-middle text-center text-capitalize">{{number_format($k->bobot_akhir/10,2) - 0.01}}</th>
                        </tr>
                        
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <!-- <a href="{{route('laporan.cetak_pdf')}}" class="btn btn-info btn-hitung mb-2"></a> -->
            <form class="form float-right" action="{{route('laporan.cetak_pdf')}}" method="post" >
            @csrf
                <!-- <input type="hidden" name="_token" value="mKJUfJZxLMNd27JVQGhwnzBV9tyKlCDeuehI8xSf"> -->
                <!-- <input type="hidden" value="2022-11-13" name="tgl_awal"> -->
                <input type="hidden" value="{{$id}}" name="id">
                <input type="hidden" value="{{$min}}" name="form_date">
                <input type="hidden" value="{{$max}}" name="to_date">
                <!-- <input type="hidden" value="bg0" name="id_bagian"> -->
                <button type="submit" class="btn btn-info btn-hitung mb-2">Cetak PDF</button>
            </form>
         </div>
    </div>
@endsection

@push('after-style')
        <!-- Custom styles for this page -->
        <link href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endpush

@push('after-script')
    <!-- Page level plugins -->
    <script src="{{asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <!-- <script src="{{asset('assets/js/demo/datatables-demo.js')}}"></script> -->
    <script>
         $(function() {
            $('#min').datepicker({
                format: 'yyyy-mm-dd',
                autoclose:true
            });
        });
        $(function() {
            $('#max').datepicker({
                format: 'yyyy-mm-dd',
                autoclose:true
            });
        });

        $(document).ready(function() {
        $('#dataTable').DataTable({
            "language":{
                "url" : "/assets/vendor/datatables/indonesia.json",
                "sEmptyTable" : "Tidads"
            },
            responsive: true,
        });
        });

        
    </script>
@endpush
