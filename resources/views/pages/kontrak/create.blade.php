@extends('layouts.default')
@section('title','Tambah Pengeluaran')
@section('header-title','Tambah Pengeluaran')

@section('content')
<div class="card shadow mb-4 col-lg-6">
    <div class="card-body">
        @if (session()->has('pesan'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{ session()->get('pesan') }}</p>
        </div>
        @endif

        <form action="{{route('kontrak.store',$id)}}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="jumlah">Nama Karyawan</label>
                <input type="text" name="nama_karyawan" readonly class="form-control @error('nama_karyawan') is-invalid @enderror" value="{{$karyawan->nama_karyawan}}">
                @error('nama_karyawan')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="Bobot">Tanggal Kerja</label>
                <div class="input-group date" id="datepicker">
                        <input type="text"  name="tgl_kerja" id="tgl_kerja" class="form-control @error('tgl_kerja') is-invalid @enderror">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>    
                </div>
                @error('tgl_kerja')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- <div class="form-group">
                <label for="Bobot">Tanggal Lahir</label>
                <div class="input-group date" id="tgl_lahir">
                        <input type="text"  name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>    
                </div>
                @error('tgl_lahir')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div> -->
            <fieldset class="form-group">
                <div class="row">
                <legend class="col-form-label col-sm-4 pt-0">Status</legend>
                    <div class="col-sm-7">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status" value="A" >
                            <label class="form-check-label" for="gridRadios1">
                                Aktif
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status" value="T">
                            <label class="form-check-label" for="gridRadios2">
                                Tidak Aktif
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset> 
            <div class="form-group">
                <label for="Bobot">Berkas Kontrak</label>
                <input type="file" name="berkas" rows="3" id="berkas" class="form-control-file @error('berkas') is-invalid @enderror"></input>
                @error('berkas')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">Kirim</button>
        </form>

    </div>
</div>

@endsection
@push('after-script')
<script type="text/javascript">
// $(function() {
//             $('#datepicker').datepicker();
//         });
    $(function() {
        $('#tgl_kerja').datepicker({
            dateFormat: 'd-m-Y'
        });
    });

</script>
@endpush
