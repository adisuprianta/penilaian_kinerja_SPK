@extends('layouts.default')
@section('title','Tambah Kriteria')
@section('header-title','Tambah Kriteria')

@section('content')
<div class="row">
        <div class="col-md-12 ">
            <h3>Tentukan Nilai Perbandingan Kriteria</h3>
                <p>
                    Untuk Menentukan Nilai Perbandingan Kriteria kamu dapat 
                    mengisi nilai 1 - 9 dari nilai 1 kurang penting sampai dengan nilai 9 sangat penting
                </p>
                                
        </div>
</div>
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
        <form action="{{route('kriteria.store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="Kriteria">Nama Kriteria</label>
                <input type="text" name="kriteria" class="form-control @error('jumlah') is-invalid @enderror">
                @error('kriteria')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Pangkat Kriteria</label>
                <select class="form-control @error('pangkat') is-invalid @enderror" name="pangkat" id="pangkat" >
                    <option selected></option>
                    @foreach($pangkat as $p)
                    <option value="{{$p->id_pangkat_karyawan}}">{{$p->nama_pangkat}}</option>
                    @endforeach
                </select>
                @error('pangkat')
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
                <label for="Nilai Bobot">Nilai Perbandingan Kriteria</label>
                <input name="nilai" type="number" max="9" min="1" value="1" rows="3" id="nilai" class="form-control @error('perincian') is-invalid @enderror"></input>
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
