<?php

namespace App\Http\Controllers;

use App\Models\karyawan;
use App\Models\Kriteria;
use App\Models\nilai_kriteria;
use App\Models\nilai_sub_kriteria;
use App\Models\Perusahaan;
use App\Models\SubKriteria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index($id){
        $karyawan = DB::table('karyawan as k')
        ->select('pk.nama_pangkat','pp.nama_perusahaan','k.id_karyawan','k.nama_karyawan','k.jenis_kelamin')
        ->join('kontrak_karyawan as kk','k.id_karyawan','=','kk.id_karyawan')->
        join('pangkat_karyawan as pk','k.id_pangkat','=','pk.id_pangkat_karyawan')->
        join('perusahaan_partner as pp', 'k.id_perusahaan','=','pp.id_perusahaan')
        
        ->where('kk.status','A')->where('pp.id_perusahaan',$id)
        ->where('pk.id_pangkat_karyawan','2')
       
        ->get();
         // ->groupBy('k.id_pangkat','k.id_karyawan','k.id_perusahaan','k.nama_karyawan','k.email','k.no_hp','k.jenis_kelamin','k.alamat','k.tanggal_lahir','k.created_at','k.updated_at')
        // ->leftJoin('nilai_sub_kriteria as ns','k.id_karyawan','=','ns.id_karyawan')
        $tanggal = Carbon::now()->format('Y-m-d');
        $nilai_kriteria = nilai_kriteria::where('tanggal_nilai',Carbon::now()->format('Y-m-d'))->get();
        $nilai_sub_kriteria=nilai_sub_kriteria::where('tanggal_nilai',Carbon::now()->format('Y-m-d'))->get();
        // dd($karyawan);
        // dd(count($nilai_kriteria));
        $perusahaan = Perusahaan::get();
        
        return view('pages.penilaian.index',['nilai_kriteria'=>$nilai_kriteria,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'perusahaan'=>$perusahaan,'karyawan'=>$karyawan,'tanggal'=>$tanggal]);
    }
    public function create($id){
        $kriteria = Kriteria::where('id_pangkat','2')->get();
        $subkriteria = SubKriteria::get();
        $perusahaan = Perusahaan::get();
        return view('pages.penilaian.create',['id'=>$id,'perusahaan'=>$perusahaan,'subkriteria'=>$subkriteria,'kriteria'=>$kriteria]);
    }
    public function store(Request $request,$id){
        $kriteria = Kriteria::where('id_pangkat','2')
        ->get();
        $subkriteria = SubKriteria::get();
        // $k=2;
        // foreach($kriteria as $k){
        //     echo $k->id;
        // }
        // dd();
        // $n="namasub".$k;
        $messages= [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
            'date'=> ':Nilai inputan harus diisi dengan tanggal',
            
        ];
        $request->validate([
            '*' => 'required',
        ],$messages);
        foreach($kriteria as $k){
            $no=0;
            foreach($subkriteria as $sk){
                if($k->id_kriteria == $sk->id_kriteria){
                    $namasub = "namasub".$sk->id_sub_kriteria;
                    echo $request->$namasub;
                    nilai_sub_kriteria::create([
                        'id_user'=>Auth::user()->id,
                        'id_karyawan'=> $id,
                        'id_sub_kriteria'=>$sk->id_sub_kriteria,
                        'tanggal_nilai'=>Carbon::now()->format('Y-m-d'),
                        'nilai_sub_kriteria'=> $request->$namasub,
                    ]);

                }else{
                    $no=$k->id_kriteria;
                }
                
            }
            echo "<br>";
            if($k->id_kriteria == $no){
                $nama= "nama".$k->id_kriteria;
                // echo $request->$nama;
                nilai_kriteria::create([
                            'id_user'=>Auth::user()->id,
                            'id_karyawan'=> $id,
                            'id_kriteria'=>$k->id_kriteria,
                            'tanggal_nilai'=>Carbon::now()->format('Y-m-d'),
                            'nilai_kriteria'=> $request->$nama,
                ]);
            }
            
        }
        // dd(Auth::user()->id);
        // dd($request->all());
        $karyawan = karyawan::find($id);
        return redirect(route('penilaian.index',$karyawan->id_perusahaan));
    }
    public function edit($id){
        $kriteria = Kriteria::where('id_pangkat','2')->get();
        $subkriteria = SubKriteria::get();
        $perusahaan = Perusahaan::get();
        $nilai_kriteria = nilai_kriteria::where('id_karyawan',$id)->get();
        $nilai_sub_kriteria=nilai_sub_kriteria::where('id_karyawan',$id)->get();
        
        return view('pages.penilaian.edit',['nilai_kriteria'=>$nilai_kriteria,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'id'=>$id,'perusahaan'=>$perusahaan,'subkriteria'=>$subkriteria,'kriteria'=>$kriteria]);
    }
    public function update($id,Request $request){
        $kriteria = Kriteria::where('id_pangkat','2')
        ->get();
        $subkriteria = SubKriteria::get();
        // $k=2;
        // foreach($kriteria as $k){
        //     echo $k->id;
        // }
        // dd();
        // $n="namasub".$k;
        $messages= [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
            'date'=> ':Nilai inputan harus diisi dengan tanggal',
            
        ];
        $request->validate([
            '*' => 'required',
        ],$messages);
        foreach($kriteria as $k){
            $no=0;
            foreach($subkriteria as $sk){
                if($k->id_kriteria == $sk->id_kriteria){
                    $namasub = "namasub".$sk->id_sub_kriteria;
                    echo $request->$namasub;
                    nilai_sub_kriteria::where('id_karyawan',$id)
                    ->where('id_sub_kriteria',$sk->id_sub_kriteria)->update([
                        'id_user'=>Auth::user()->id,
                        'nilai_sub_kriteria'=> $request->$namasub,
                    ]);

                }else{
                    $no=$k->id_kriteria;
                }
                
            }
            echo "<br>";
            if($k->id_kriteria == $no){
                $nama= "nama".$k->id_kriteria;
                // echo $request->$nama;
                nilai_kriteria::where('id_karyawan',$id)
                ->where('id_kriteria',$k->id_kriteria)->update([
                            'id_user'=>Auth::user()->id,
                            'nilai_kriteria'=> $request->$nama,
                ]);
            }
            
        }
        // dd(Auth::user()->id);
        // dd($request->all());
        $karyawan = karyawan::find($id);
        return redirect(route('penilaian.index',$karyawan->id_perusahaan));
    }
}
