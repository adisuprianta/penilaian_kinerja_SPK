@extends('layouts.default')
@section('title','Data Pekerjaan ')
@section('header-title','Data Pekerjaan ')

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
                <a href="{{route('pekerjaan.create')}}" class="btn btn-success mb-4">
                    Tambah
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
                <table class="table table-striped table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pekerjaan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pekerjaan as $p)
                        <th>{{ $loop->iteration }}.</th>
                        <th>{{ $p->nama_pekerjaan}}</th>
                        <th>
                        <div class="d-flex justify-content-center">
                                <a class="btn btn-info " href="{{route('pekerjaan.edit',$k->id_pekerjaan)}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Ubah
                                </a>
                                <form action="{{route('pekerjaan.destroy',$p->id_pekerjaan)}}" method="post" class="d-inline" id="{{'form-hapus-pekerjaan-'.$k->id_pekerjaan}}">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger btn-sm btn-hapus" data-id="{{$k->id_pekerjaan}}" data-username="{{$k->nama_pekerjaan}}"  type="submit">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                    </form>
                            </div>
                        </th>
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
            let form = $('#form-hapus-pekerjaan-'+id);
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
