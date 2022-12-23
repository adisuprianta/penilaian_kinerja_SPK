@extends('layouts.default')
@section('title','Data user')
@section('header-title','Data user')

@section('content')
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
                            <th>No.</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Nama Perusahaan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($user as $u)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{$u ->name}}</td>
                                <td>{{$u->email}}</td>
                                <td>{{$u->display_name}}</td>
                                <td>{{$u->nama_perusahaan}}</td>
                                <td>
                                    <a class="btn btn-info btn-sm mb-1 mr-1 d-inline" href="{{route('user.edit',$u->id)}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Ubah
                                    </a>
                                    <form action="{{route('user.destroy',$u->id)}}" method="post" class="d-inline" id="{{'form-hapus-user-'.$u->id}}">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm btn-hapus" data-id="{{$u->id}}" data-username="{{$u->name}}"  type="submit">
                                            <i class="fas fa-trash">
                                            </i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
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
    @include('sweetalert::alert')php artisan sweetalert:publish
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
