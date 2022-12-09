@extends('layouts.default')
@section('title','Data user')
@section('header-title','Data user')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
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
                
                <!-- <a href="" class="btn btn-success mb-4">
                    Kontrak Kerja
                    <i class="fa fa-file-signature"></i>
                </a> -->
                <table class="table table-striped table-bordered " id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama Karyawan</th>
                            <th scope="col">Berkas Kontrak Kerja</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal Masuk</th>
                            <th scope="col">Tanggal Kerja</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($kontrak as $k)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{$k->nama_karyawan}}</td>
                            <th>{{$k->berkas_kontrak}}</th>
                            <th>{{$k->status}}</th>
                            <th>{{$k->tanggal_masuk}}</th>
                            <th>{{$k->tanggal_kerja}}</th>
                            <th>
                                <div class="d-flex justify-content-end">
                                    
                                    @if($k->status == null)
                                    <a class="btn btn-info btn-sm w-100 h-100 "  href="{{route('kontrak.create',$k->id)}}">
                                        <i class="fas fa-plus">
                                        </i>
                                        Kontrak Kerja
                                    </a>   
                                    @else
                                      
                                    <a class="btn btn-info btn-sm w-100 h-100 "  href="{{route('kontrak.edit',$k->id)}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Ubah
                                    </a>
                                    <form action="{{route('kontrak.destroy',$k->id_kontrak)}}" method="post" class="ml-2 d-inline" id="{{'form-hapus-kontrak-'.$k->id_kontrak}}">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm  btn-hapus w-100 h-100" data-id="{{$k->id_kontrak}}" data-username="{{$k->nama_karyawan}}"  type="submit">
                                        <i class="fas fa-trash"></i> 
                                            Hapus
                                        </button>
                                    </form>            
                                    @endif
                                </div>
                               
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
            let form = $('#form-hapus-kontrak-'+id);
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
