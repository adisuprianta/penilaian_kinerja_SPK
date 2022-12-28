@extends('layouts.default')
@section('title','Data user')
@section('header-title','Penilaian')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
        <h3 class="float-right card-title h4 mb-4 text-gray-800">Tanggal : {{$tanggal}}</h3>
            <div class="table-responsive">
            @if ($message = Session::get('sukses'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                @if ($message = Session::get('gagal'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                @if ($message = Session::get('peringatan'))
                <div class="alert alert-warning alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                <!-- <a href="{{route('karyawan.create')}}" class="btn btn-success mb-4">
                    Tambah
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a> -->
                
                <!-- <a href="" class="btn btn-success mb-4">
                    Kontrak Kerja
                    <i class="fa fa-file-signature"></i>
                </a> -->
                <table class="table table-striped table-bordered " id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama Karyawan</th>
                            <th scope="col">Pangkat Karyawan</th>
                            <th scope="col">Perusahaan</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($karyawan as $k)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{$k->nama_karyawan}}</td>
                            <th>{{$k->nama_pangkat}}</th>
                            <th>{{$k->nama_perusahaan}}</th>
                            @if($k->jenis_kelamin == "L")
                            <th>Laki Laki</th>
                            @elseif($k->jenis_kelamin == "P")
                            <th>Perempuan</th>
                            @endif
                            <th>
                                @php
                                $cek=0;
                                $c=0;
                                @endphp
                                @foreach($nilai_sub_kriteria as $nk)
                                    @if($nk->id_karyawan == $k->id_karyawan)
                                        @php
                                           $cek=1;
                                        @endphp
                                    @endif
                                @endforeach
                                @foreach($nilai_kriteria as $nk)
                                    @if($nk->id_karyawan == $k->id_karyawan)
                                        @php
                                            $c=1;
                                        @endphp
                                    @endif
                                @endforeach
                                @if($c == 0 AND $cek == 0)
                                <a class="btn btn-info btn-sm w-100 h-100" href="{{route('penilaian_manajer.create',$k->id_karyawan)}}">
                                   <span>Nilai</span>
                                </a>
                                @else
                                <form action="{{route('penilaian_manajer.edit',$k->id_karyawan)}}" method="post" class=" d-inline" id="{{'form-hapus-karyawan-'.$k->id_karyawan}}">
                                <input type="hidden" value="{{$tanggal}}" name="tgl_bobot">
                                    @csrf

                                    <button class="btn btn-info btn-sm w-100 h-100"  type="submit">
                                    
                                        Edit
                                    </button>
                                    </form>
                                
                                @endif
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <form class="form float-right" action="{{route('penilaian_manajer.hitung')}}" method="post" >
            @method('PUT')
            @csrf
                <!-- <input type="hidden" name="_token" value="mKJUfJZxLMNd27JVQGhwnzBV9tyKlCDeuehI8xSf"> -->
                <!-- <input type="hidden" value="2022-11-13" name="tgl_awal"> -->
                <input type="hidden" value="{{$tanggal}}" name="tgl">
                <!-- <input type="hidden" value="bg0" name="id_bagian"> -->
                <button type="submit" class="btn btn-info btn-hitung mb-2">Hitung</button>
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
    <script src="{{asset('assets/js/demo/datatables-demo.js')}}"></script>
    
    <script>
        $('.btn-hapus').on('click', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let form = $('#form-hapus-user-'+id);
            let username = $(this).data('username');

            Swal.fire({
            title: 'Apakah anda yakin?',
            text: username +' akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#5bc0de',
            confirmButtonColor: '#d9534f ',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            })

        });
    </script>
@endpush
