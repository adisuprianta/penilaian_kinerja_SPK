@extends('layouts.default')
@section('title','Penilaian '.$karyawan->nama_karyawan)
@section('header-title','Penilaian '.$karyawan->nama_karyawan)

@section('content')
<div class="card shadow mb-4 col-lg-6">
    <div class="card-body">
        @if (session()->has('pesan'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{ session()->get('pesan') }}</p>
        </div>
        @endif

        <form action="{{route('penilaian_manajer.store',$id)}}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @foreach($kriteria as $k)
                <h4 class="h4 mb-4 text-gray-800">{{$k->nama_kriteria}}</h4>
                @php
                $no=0
                @endphp
                @foreach($subkriteria as $sk)
                    @if($k->id_kriteria == $sk->id_kriteria)
                    <div class="form-group ">
                        <label for="jumlah">{{$sk->nama_sub_kriteria}}</label>
                        <!-- <div class="form-inline "> -->
                            <div class="form-check ">
                                <input class="form-check-input" type="radio" name="namasub{{$sk->id_sub_kriteria}}" id="inlineRadio1" value="1">
                                <label class="form-check-label" for="namasub{{$sk->id_sub_kriteria}}">Kurang Sekali</label>
                            </div>
                            <div class="form-check ">
                                <input class="form-check-input" type="radio" name="namasub{{$sk->id_sub_kriteria}}" id="inlineRadio2" value="2">
                                <label class="form-check-label" for="namasub{{$sk->id_sub_kriteria}}">Kurang</label>
                            </div><div class="form-check ">
                                <input class="form-check-input" type="radio" name="namasub{{$sk->id_sub_kriteria}}" id="inlineRadio3" value="3">
                                <label class="form-check-label" for="namasub{{$sk->id_sub_kriteria}}">Cukup</label>
                            </div>
                            <div class="form-check ">
                                <input class="form-check-input" type="radio" name="namasub{{$sk->id_sub_kriteria}}" id="inlineRadio4" value="4">
                                <label class="form-check-label" for="namasub{{$sk->id_sub_kriteria}}">Cukup Baik</label>
                            </div>
                            <div class="form-check ">
                                <input class="form-check-input" type="radio" name="namasub{{$sk->id_sub_kriteria}}" id="inlineRadio5" value="5">
                                <label class="form-check-label" for="namasub{{$sk->id_sub_kriteria}}">Baik</label>
                            </div>
                        <!-- </div> -->
                        <!-- <input type="number" name="namasub{{$sk->id_sub_kriteria}}" class="form-control  @error('namasub$sk->id_sub_kriteria') is-invalid @enderror" min="0" max="100" value="0"> -->
                        @error('namasub$sk->id_sub_kriteria')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                        @php
                            $no=$k->id_kriteria
                        @endphp
                    @endif
                @endforeach
                @if($k->id_kriteria == $no)
                    
                @else
                <div class="form-group">
                        <label for="jumlah">{{$k->nama_kriteria}}</label>
                        <div class="form-check ">
                            <input class="form-check-input" type="radio" name="nama{{$k->id_kriteria}}" id="nama{{$k->id_kriteria}}" value="1">
                            <label class="form-check-label" for="nama{{$k->id_kriteria}}">Kurang Sekali</label>
                        </div>
                        <div class="form-check ">
                            <input class="form-check-input" type="radio" name="nama{{$k->id_kriteria}}" id="nama{{$k->id_kriteria}}" value="2">
                            <label class="form-check-label" for="nama{{$k->id_kriteria}}">Kurang</label>
                        </div><div class="form-check ">
                            <input class="form-check-input" type="radio" name="nama{{$k->id_kriteria}}" id="nama{{$k->id_kriteria}}" value="3">
                            <label class="form-check-label" for="nama{{$k->id_kriteria}}">Cukup</label>
                        </div>
                        <div class="form-check ">
                            <input class="form-check-input" type="radio" name="nama{{$k->id_kriteria}}" id="nama{{$k->id_kriteria}}" value="4">
                            <label class="form-check-label" for="nama{{$k->id_kriteria}}">Cukup Baik</label>
                        </div>
                        <div class="form-check ">
                            <input class="form-check-input" type="radio" name="nama{{$k->id_kriteria}}" id="nama{{$k->id_kriteria}}" value="5">
                            <label class="form-check-label" for="nama{{$k->id_kriteria}}">Baik</label>
                        </div>
                        <!-- <input type="number" name="nama{{$k->id_kriteria}}" class="form-control @error('nama{{$k->id_kriteria}}') is-invalid @enderror" min="0" max="100" value="0"> -->
                        @error('nama{{$k->id_kriteria}}')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @endif
            @endforeach
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
        $('#tgl_lahir').datepicker({
            dateFormat: 'd-m-Y'
        });
    });

</script>
@endpush
