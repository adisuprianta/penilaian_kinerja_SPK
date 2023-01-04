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

        <form action="{{route('penilaian.store',$id)}}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @foreach($kriteria as $k)
                <h4 class="h4 mb-4 text-gray-800">{{$k->nama_kriteria}}</h4>
                @php
                $no=0
                @endphp
                @foreach($subkriteria as $sk)
                    @if($k->id_kriteria == $sk->id_kriteria)
                    <div class="form-group">
                        <label for="jumlah">{{$sk->nama_sub_kriteria}}</label>
                        <input type="number" max="5" min="1" value="1" name="namasub{{$sk->id_sub_kriteria}}" class="form-control  @error('namasub$sk->id_sub_kriteria') is-invalid @enderror" >
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
                        <input type="number" max="5" min="1" value="1" name="nama{{$k->id_kriteria}}" class="form-control @error('nama{{$k->id_kriteria}}') is-invalid @enderror" >
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
