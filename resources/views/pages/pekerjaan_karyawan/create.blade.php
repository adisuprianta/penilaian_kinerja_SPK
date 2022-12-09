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
        <form action="{{route('pekerjaan_karyawan.store',$id)}}" method="post">
            @csrf
            <div class="form-group">
                <label for="Kriteria">Nama Pekerjaan</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror">
                @error('nama')
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
