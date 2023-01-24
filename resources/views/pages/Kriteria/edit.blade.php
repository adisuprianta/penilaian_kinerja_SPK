@extends('layouts.default')
@section('title','Edit Kriteria')
@section('header-title','Edit Kriteria')

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
        <form action="{{route('kriteria.update',$id)}}" method="post">
        @method('PUT')
        @csrf
            <div class="form-group">
                <label for="Kriteria">Nama Sub Kriteria</label>
                <input type="text" name="kriteria"  class="form-control @error('jumlah') is-invalid @enderror" value="{{$kriteria->nama_kriteria}}">
                @error('kriteria')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Pangkat Kriteria</label>
                <select class="form-control @error('pangkat') is-invalid @enderror" name="pangkat" id="pangkat" >
                    <!-- <option selected></option> -->
                    @foreach($pangkat as $p)
                        @if($p->id_pangkat_karyawan == $kriteria->id_pangkat)
                            <option selected value="{{$p->id_pangkat_karyawan}}">{{$p->nama_pangkat}}</option>
                        @else
                            <option value="{{$p->id_pangkat_karyawan}}">{{$p->nama_pangkat}}</option>
                        @endif
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
                    @if($kriteria->golongan =="B")
                    <!-- <option selected></option> -->
                    <option selected value="B">Benefit</option>
                    <option value="C">Cost</option>
                    @else
                    <!-- <option selected></option> -->
                    <option value="B">Benefit</option>
                    <option selected value="C">Cost</option>

                    @endif
                </select>
                @error('golongan')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="Nilai Bobot">Nilai Perbandingan Sub Kriteria</label>
                <input name="nilai" rows="3" type="number" max="9" min="1"  id="nilai" class="form-control @error('perincian') is-invalid @enderror" value="{{$kriteria->nilai_perbandingan_kriteria}}"></input>
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
