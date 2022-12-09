@extends('layouts.default')
@section('title','Data Pekerjaan Karyawan')
@section('header-title','Data Pekerjaan Karyawan ')

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
                <a href="{{route('perusahaan.create')}}" class="btn btn-success mb-4">
                    Tambah
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
                <table class="table table-striped table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pekerjaan</th>
                            <th>Alamat Perusahaan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($perusahaan as $p)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{$p->nama_perusahaan}}</td>
                            <td>{{$p->alamat_perusahaan}}</td>
                            
                            <th>
                                <a class="btn btn-info btn-sm mb-1 mr-1 d-inline" href="{{route('perusahaan.edit',$p->id_perusahaan)}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Ubah
                                </a>
                                <form action="{{route('perusahaan.destroy',$p->id_perusahaan)}}" method="post" class="d-inline" id="{{'form-hapus-perusahaan-'.$p->id_perusahaan}}">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger btn-sm btn-hapus" data-id="{{$p->id_perusahaan}}" data-username="{{$p->nama_perusahaan}}"  type="submit">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                    </form>
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
            let form = $('#form-hapus-perusahaan-'+id);
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
