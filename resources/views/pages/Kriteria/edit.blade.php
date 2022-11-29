@extends('layouts.default')
@section('title','Edit Kriteria')
@section('header-title','Edit Kriteria')

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
        <form action="{{route('sub_kriteria.update',$id)}}" method="post">
        @method('PUT')
        @csrf
            <div class="form-group">
                <label for="Kriteria">Nama Sub Kriteria</label>
                <input type="text" name="kriteria" class="form-control @error('jumlah') is-invalid @enderror" value="{{$kriteria->nama_kriteria}}">
                @error('kriteria')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="Nilai Bobot">Nilai Perbandingan Sub Kriteria</label>
                <input name="nilai" rows="3" id="nilai" class="form-control @error('perincian') is-invalid @enderror" value="{{$kriteria->nilai_perbandingan_kriteria}}"></input>
                @error('nilai')
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