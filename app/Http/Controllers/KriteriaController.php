<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\Pangkat_karyawan;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
class KriteriaController extends Controller
{
    public function show($id){
            return view("pages.subkriteria.index");
        }
    public function index(){
        $kriteria = Kriteria::join('pangkat_karyawan as pk','id_pangkat','=','id_pangkat_karyawan')->get();
        return view('pages.kriteria.index',['kriteria'=>$kriteria]);
    }
    public function create(){
        $pangkat = Pangkat_karyawan::get();
        return view('pages.kriteria.create',["pangkat"=>$pangkat]);
    }
    public function store(Request $request){
        $messages = [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
        ];
        $request->validate([
            'kriteria' => ['required', 'string', 'max:255'],
            'pangkat'=>['required'],
            'nilai' => ['required', 'numeric','between: 1,9' ],
            'golongan'=>['required'],
        ],$messages);

        Kriteria::create([
            'id_pangkat'=>$request->pangkat,
            'nama_kriteria' => $request->kriteria,
            'nilai_perbandingan_kriteria' =>$request->nilai,
            'bobot_kriteria'=>"0",
            'golongan'=>$request->golongan,
        ]);
        $kriteria = Kriteria::get();
        $this->HitungBobotKriteria($kriteria);

        Alert::success('sukses','Berhasil menginputkan data');
        return redirect(route('kriteria.index'));
    }

    public function HitungBobotKriteria($kriteria){
        
        $row = 0; 
        $con = 0;
        
        // matriks perbandingan pasangan
        $matriks = array();
        foreach($kriteria as $k){
            $con = 0;
            foreach($kriteria as $kri){
                $matriks[$row][$con] = $k->nilai_perbandingan_kriteria/$kri->nilai_perbandingan_kriteria;
                $con++;
            }
            $row++;
        }
        // dd($matriks);
        // hitung jumlah
        $jumlah=array();
        for($i=0;$i<count($matriks[0]);$i++){
            $jumlah[$i] = 0;
            for($j=0;$j<count($matriks[0]);$j++){
                $jumlah[$i]=$jumlah[$i]+$matriks[$j][$i];
                
            }
        }

        //normalisasi
        $normalisi = array();
        for($i=0;$i<count($jumlah);$i++){
            
            for($j=0; $j< count($matriks[0]);$j++){
                $normalisi[$i][$j] = $matriks[$j][$i] / $jumlah[$i]; 
            }
            
        }
        
        // jumlah normalisasi
        $jm=array();
        for($i=0;$i<count($jumlah);$i++){
            $jm[$i]=0;
            for($j=0; $j< count($matriks[0]);$j++){
                $jm[$i]+= $normalisi[$j][$i] ;
                // echo $normalisi[$j][$i]."aku" ;
            }
        }

        // menghitung bobot kriteria
        //$bobot = array();
        for($i=0;$i<count($jumlah);$i++){
            $bobot[$i]=$jm[$i]/count($jm);
        }
        // dd($bobot);
        $row=0;
        foreach($kriteria as $k){
            Kriteria::where('id_kriteria',$k->id_kriteria)->update([
                    "bobot_kriteria"=>$bobot[$row],
            ]);
            $row++;
        }
        return $bobot;
    }
    public function edit($id){
        $pangkat = Pangkat_karyawan::get();
        $kriteria = Kriteria::find($id);
        return view("pages.kriteria.edit",['pangkat'=>$pangkat,"id"=>$id,"kriteria"=>$kriteria]);
    }
    public function update($id, Request $request){
        $messages = [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
        ];
        $request->validate([
            'kriteria' => ['required', 'string', 'max:255'],
            'pangkat'=>['required'],
            'nilai' => ['required', 'numeric','between: 1,9' ],
            'golongan'=>['required'],
        ],$messages);

        Kriteria::where("id_kriteria",$id)->update([
            'id_pangkat'=>$request->pangkat,
            'nama_kriteria' => $request->kriteria,
            'nilai_perbandingan_kriteria' =>$request->nilai,
            'golongan'=>$request->golongan,
        ]);
        $kriteria = Kriteria::get();
        $this->HitungBobotkriteria($kriteria);

        Alert::success('sukses','Berhasil mengupdate data');
        return redirect(route('kriteria.index'));
    }

    public function destroy($id){
        $kriteria =Kriteria::find();
        $kriteria->delete();
        $kriteria = Kriteria::get();
        $this->HitungBobotKriteria($kriteria);
        Alert::success('sukses','Berhasil delete data');
        return redirect(route('kriteria.index'));
    }
}
