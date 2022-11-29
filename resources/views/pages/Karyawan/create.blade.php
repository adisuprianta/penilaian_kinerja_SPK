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

        <form action="{{route('kriteria.store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="jumlah">Nama Karyawan</label>
                <input type="text" name="nama_karyawan" class="form-control @error('jumlah') is-invalid @enderror">
                @error('nama_karyawan')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="Bobot">No Hp</label>
                <input name="nohp" rows="3" id="nohp" class="form-control @error('perincian') is-invalid @enderror"></input>
                @error('nohp')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <fieldset class="form-group">
                <div class="row">
                <legend class="col-form-label col-sm-4 pt-0">Jenis Kelamin</legend>
                    <div class="col-sm-7">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gridRadios" id="jkel" value="L" checked>
                            <label class="form-check-label" for="gridRadios1">
                                Laki Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gridRadios" id="jkel" value="P">
                            <label class="form-check-label" for="gridRadios2">
                                Perempuan
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>
                        
            <div class="form-group">
                <label for="Bobot">Alamat</label>
                <input name="alamat" rows="3" id="alamat" class="form-control @error('perincian') is-invalid @enderror"></input>
                @error('alamat')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="Bobot">Tanggal Kerja</label>
                <div class="input-group date" id="datepicker">
                        <input type="text" class="form-control">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>
                    </div>
                <input name="tgl_kerja" rows="3" id="tgl_kerja" class="form-control @error('perincian') is-invalid @enderror"></input>
                @error('tgl_kerja')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="Bobot">Alamat</label>
                <input name="alamat" rows="3" id="alamat" class="form-control @error('perincian') is-invalid @enderror"></input>
                @error('alamat')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="Bobot">Alamat</label>
                <input name="alamat" rows="3" id="alamat" class="form-control @error('perincian') is-invalid @enderror"></input>
                @error('alamat')
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
