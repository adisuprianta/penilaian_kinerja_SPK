@extends('layouts.default')
@section('title','Tambah Perusahaan')
@section('header-title','Tambah Perusahaan')

@section('content')
<div class="card shadow mb-4 col-lg-6">
    <div class="card-body">
        <br/>
        {{-- menampilkan error validasi --}}
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

        <br/>
        <form action="{{route('perusahaan.store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="Kriteria">Nama Perusahaan</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror">
                @error('nama')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="jumlah">Email Perusahaan</label>
                <input id="email" type="email" name="email" :value="old('email')" required class="form-control @error('nama_karyawan') is-invalid @enderror">
                @error('nama_karyawan')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="Bobot">Nomor Perusahaan</label>
                <input name="nohp" rows="3" id="nohp" class="form-control @error('nohp') is-invalid @enderror"></input>
                @error('nohp')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="Kriteria">Kota</label>
                <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror">
                @error('kota')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="Kriteria">Alamat</label>
                <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror">
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
