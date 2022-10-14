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
                <label for="jumlah">kriteria</label>
                <input type="text" name="kriteria" class="form-control @error('jumlah') is-invalid @enderror">
                @error('kriteria')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="Bobot">Bobot</label>
                <input name="bobot" rows="3" id="bobot" class="form-control @error('perincian') is-invalid @enderror"></input>
                @error('bobot')
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
