@extends('layouts.default')
@section('title','Tambah Kriteria')
@section('header-title','Tambah Kriteria')

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
        <form action="{{route('perusahaan.update',$perusahaan->id_perusahaan)}}" method="post">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="Kriteria">Nama Perusahaan</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{$perusahaan->nama_perusahaan}}">
                @error('nama')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="Kriteria">Alamat</label>
                <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{$perusahaan->alamat_perusahaan}}">
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
