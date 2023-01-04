@extends('layouts.default')
@section('title','Tambah Sub Kriteria')
@section('header-title','Tambah Sub Kriteria')

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
        <form action="{{route('sub_kriteria.masukandata',$id)}}" method="post">
        @method('PUT')
        @csrf
            <div class="form-group">
                <label for="Kriteria">Nama Sub Kriteria</label>
                <input type="text" name="kriteria" class="form-control @error('jumlah') is-invalid @enderror">
                @error('kriteria')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Golongan Kriteria</label>
                <select class="form-control @error('golongan') is-invalid @enderror" name="golongan" id="golongan" >
                    <option selected></option>
                    <option value="B">Benefit</option>
                    <option value="C">Cost</option>
                </select>
                @error('golongan')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="Nilai Bobot">Nilai Perbandingan Sub Kriteria</label>
                <input name="nilai" rows="3" type="number" max="9" min="1" value="1"  id="nilai" class="form-control @error('perincian') is-invalid @enderror"></input>
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
