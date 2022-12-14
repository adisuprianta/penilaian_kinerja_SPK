@extends('layouts.default')
@section('title','Tambah Pengeluaran')
@section('header-title','Edit Penilaian')

@section('content')
<div class="card shadow mb-4 col-lg-6">
    <div class="card-body">
        @if (session()->has('pesan'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{ session()->get('pesan') }}</p>
        </div>
        @endif

        <form action="{{route('penilaian.update',$id)}}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @foreach($kriteria as $k)
                <h5 class="h5 mb-4 text-gray-800">{{$k->nama_kriteria}}</h5>
                @php
                $no=0
                @endphp
                @foreach($subkriteria as $sk)
                    @if($k->id_kriteria == $sk->id_kriteria)
                        @foreach($nilai_sub_kriteria as $ns)
                            @if($ns->id_sub_kriteria == $sk->id_sub_kriteria)    
                                <div class="form-group">
                                    <label for="jumlah">{{$sk->nama_sub_kriteria}}</label>
                                    <input type="number" name="namasub{{$sk->id_sub_kriteria}}" class="form-control  @error('namasub$sk->id_sub_kriteria') is-invalid @enderror" min="0" max="100" value="{{$ns->nilai_sub_kriteria}}">
                                    @error('namasub$sk->id_sub_kriteria')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            @endif
                        @endforeach
                    @else
                    @php
                        $no=$k->id_kriteria
                    @endphp
                    @endif
                
                @endforeach
                @if($k->id_kriteria == $no)
                    @foreach($nilai_kriteria as $nk)
                        @if($nk->id_kriteria == $k->id_kriteria)        
                            <div class="form-group">
                                <label for="jumlah">{{$k->nama_kriteria}}</label>
                                <input type="number" name="nama{{$k->id_kriteria}}" class="form-control @error('nama{{$k->id_kriteria}}') is-invalid @enderror" min="0" max="100" value="{{$nk->nilai_kriteria}}">
                                @error('nama{{$k->id_kriteria}}')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        @endif
                    @endforeach
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
