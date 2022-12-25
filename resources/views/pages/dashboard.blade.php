@extends('layouts.default')
@section('title','Beranda')

@section('content')

<div class="container mb-4">
        <div class="row">
            <div class="col-md-12">
                
            </div>
        </div>
        <!-- home -->
		<div class="row home">
            <div class="col-md-10 offset-1 content-home">
                <div class="row">
                    <div class="col-md-5">
                        <p>
                            Aplikasi penilain kinerja karyawan 
                            ini digunakan untuk menentukan karyawan terbaik melalui 
                            ranking karyawan yang dapat 
dilihat setelah melakukan perhitungan metode Analytical Hierarchy Process (AHP) dan metode Simple Additive Weighting (SAW).
                        </p>
                    </div>
                    <div class="col-md-6 image">
                        <img src="{{asset('img/home-logo.png')}}" alt="" height="240">
                    </div>
                </div>
            </div>
            
        </div>
        <!-- grafik -->
        <h3 class="judul-grafik">GRAFIK INFORMASI CALON KARYAWAN</h3>
        <div class="row grafik">
        <div class="col-md-10 offset-1">
            <div class="row">
                <div class="col-sm-8 col-lg-4">
                    <div class="card text-white bg-flat-color-1">
                        <div class="card-body pb-0">
                            <h4 class="mb-0 text-light">
                            Jumlah Karyawan
                            </h4>
                            <h5 class="text-light">{{$jumlah}} Orang</h5>

                        </div>
                        <div class="chart-wrapper px-0" style="height:70px;" height="70">
                            <canvas id="widgetChart3"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8 col-lg-4">
                    <div class="card text-white bg-flat-color-3">
                        <div class="card-body pb-0">
                            <h4 class="mb-0 text-light">
                                Karyawan Terbaik
                            </h4>
                            <p class="text-light"></p>

                            <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                <canvas id="widgetChart1"></canvas>
                            </div>

                        </div>

                    </div>
                </div>
                <!--/.col-->

                <div class="col-sm-8 col-lg-4">
                    <div class="card text-white bg-flat-color-2">
                        <div class="card-body pb-0">
                            <h4 class="mb-0 text-light">
                                Karyawan Terendah
                            </h4>
                            <p class="text-light"></p>
                            <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                <canvas id="widgetChart2"></canvas>
                            </div>

                        </div>
                    </div>
                </div>
                <!--/.col-->

                
            </div>
        </div>
        
            
            <!--/.col-->

            
        </div>
    </div>


<div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <a href="{{route('user.create')}}" class="btn btn-success mb-4">
                    Tambah
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
                <table class="table table-striped table-bordered" id="dataTable">
                    <thead>
                        
                        <tr>
                            <th rowspan="2" class="align-middle text-center text-capitalize">No.</th>
                            <th rowspan="2" class="align-middle text-center text-capitalize">nama karyawan</th>
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
                                    <th class="align-middle text-center text-capitalize" colspan="{{$jum}}">{{$k->nama_kriteria}}</th>
                                @else
                                    <th rowspan="2" class="align-middle text-center text-capitalize">{{$k->nama_kriteria}}</th>
                                @endif
                            @endforeach
                            <th rowspan="2" class="align-middle text-center text-capitalize">Bobot Akhir</th>
                        </tr>
                        <tr>
                            @foreach($kriteria as $k)
                                @foreach($subkriteria as $sk)
                                    @if($k->id_kriteria == $sk->id_kriteria)
                                        <th class="align-middle text-capitalize text-center" >{{$sk->nama_sub_kriteria}}</th>
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
                                                <th class="align-middle text-center text-capitalize">{{$ns->nilai_sub_kriteria}}</th> 
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
                                            <th class="align-middle text-center text-capitalize">{{$nk->nilai_kriteria}}</th>     
                                        @endif
                                    @endforeach
                                    @if($cek == 0)
                                        <th></th>
                                    @endif
                                @endif
                            @endforeach
                            <th  class="align-middle text-center text-capitalize">{{$k->bobot_akhir}}</th>
                        </tr>
                        
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('after-script')
    <!-- Page level plugins -->
    <script src="{{asset('assets/vendor/chart.js/Chart.min.js')}}"></script>
@endpush
