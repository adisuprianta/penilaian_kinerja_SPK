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

        <form action="{{route('karyawan.update',$karyawan->id_karyawan)}}" method="post" >
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="jumlah">Nama Karyawan</label>
                <input type="text" name="nama_karyawan" class="form-control @error('nama_karyawan') is-invalid @enderror" value="{{$karyawan->nama_karyawan}}">
                @error('nama_karyawan')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="jumlah">Email</label>
                <input id="email" value="{{$karyawan->email}}" type="email" name="email" :value="old('email')" required class="form-control @error('nama_karyawan') is-invalid @enderror">
                @error('nama_karyawan')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="Bobot">No Hp</label>
                <input name="nohp" value="{{$karyawan->no_hp}}" rows="3" id="nohp" class="form-control @error('nohp') is-invalid @enderror"></input>
                @error('nohp')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Perusahaan</label>
                <select class="form-control  @error('perusahaan') is-invalid @enderror" name="perusahaan" id="perusahaan">
                    <option selected></option>
                    @foreach($perusahaan as $p)
                        @if($p->id_perusahaan==$karyawan->id_perusahaan)
                            <option value="$p->id_perusahaan" selected>{{$p->nama_perusahaan}}</option>
                        @else
                            <option value="$p->id_perusahaan">{{$p->nama_perusahaan}}</option>
                        @endif
                        
                    @endforeach
                </select>
                @error('perusahaan')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Pangkat Karyawan</label>
                <select class="form-control @error('pangkat') is-invalid @enderror" name="pangkat" id="pangkat" >
                    @foreach($pangkat as $p)
                    @if($p->id_pangkat_karyawan==$karyawan->id_pangkat)
                            <option value="{{$p->id_pangkat_karyawan}}" selected>{{$p->nama_pangkat}}</option>
                        @else
                        <option value="{{$p->id_pangkat_karyawan}}" >{{$p->nama_pangkat}}</option>
                        @endif
                    @endforeach
                </select>
                @error('pangkat')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- <fieldset class="form-group">
                <div class="row">
                <legend class="col-form-label col-sm-4 pt-0">Jenis Kelamin</legend>
                    <div class="col-sm-7">
                        @if($karyawan->jenis_kelamin=="L")
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jkel" id="jkel" value="L" checked>
                            <label class="form-check-label" for="gridRadios1">
                                Laki Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jkel" id="jkel" value="P">
                            <label class="form-check-label" for="gridRadios2">
                                Perempuan
                            </label>
                        </div>
                        @elseif($karyawan->jenis_kelamin=="P")
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jkel" id="jkel" value="L" >
                            <label class="form-check-label" for="gridRadios1">
                                Laki Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jkel" id="jkel" value="P" checked>
                            <label class="form-check-label" for="gridRadios2">
                                Perempuan
                            </label>
                        @endif
                        </div>
                    </div>
                </div>
            </fieldset>  -->
            <fieldset class="form-group">
                <div class="row">
                <legend class="col-form-label col-sm-4 pt-0">Jenis Kelamin</legend>
                    <div class="col-sm-7">
                    @if($karyawan->jenis_kelamin=="L")
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jkel" id="jkel" value="L" checked>
                            <label class="form-check-label" for="gridRadios1">
                                Laki Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jkel" id="jkel" value="P">
                            <label class="form-check-label" for="gridRadios2">
                                Perempuan
                            </label>
                        </div>
                        @elseif($karyawan->jenis_kelamin=="P")
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jkel" id="jkel" value="L" >
                            <label class="form-check-label" for="gridRadios1">
                                Laki Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jkel" id="jkel" value="P" checked>
                            <label class="form-check-label" for="gridRadios2">
                                Perempuan
                            </label>
                        @endif
                    </div>
                </div>
            </fieldset>
                        
            <div class="form-group">
                <label for="Bobot">Alamat</label>
                <input name="alamat" value="{{$karyawan->alamat}}"  rows="3" id="alamat" class="form-control @error('alamat') is-invalid @enderror"></input>
                @error('alamat')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- <div class="form-group">
                <label for="Bobot">Tanggal Kerja</label>
                <div class="input-group date" id="datepicker">
                        <input type="text"  name="tgl_kerja" class="form-control @error('tgl_kerja') is-invalid @enderror">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>    
                </div>
                @error('tgl_kerja')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div> -->

            <div class="form-group">
                <label for="Bobot">Tanggal Lahir</label>
                <div class="input-group date" id="tgl_lahir">
                        <input type="text" value="{{$karyawan->tanggal_lahir}}"   name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>    
                </div>
                @error('tgl_lahir')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <!-- <fieldset class="form-group">
                <div class="row">
                <legend class="col-form-label col-sm-4 pt-0">Status</legend>
                    <div class="col-sm-7">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status" value="A" >
                            <label class="form-check-label" for="gridRadios1">
                                Aktif
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status" value="T">
                            <label class="form-check-label" for="gridRadios2">
                                Tidak Aktif
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset> -->
            <!-- <div class="form-group">
                <label for="Bobot">Berkas Kontrak</label>
                <input type="file" name="berkas" rows="3" id="berkas" class="form-control-file @error('berkas') is-invalid @enderror"></input>
                @error('berkas')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div> -->
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