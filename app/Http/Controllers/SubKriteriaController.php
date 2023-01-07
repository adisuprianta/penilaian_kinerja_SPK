<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
class SubKriteriaController extends Controller
{
    // public function index(){
    //     return "AAAA";
    // }
    public function show($id){
        // return "a";
        
        $subkriteria = SubKriteria::where("id_kriteria",$id)->get();
        return view("pages.subkriteria.index",["id"=>$id,"subkriteria"=>$subkriteria,"kriteria"=>$kriteria]);
    }
    public function create($id){
        $kriteria = Kriteria::find($id);
        return view("pages.subkriteria.create",["id"=>$id,"kriteria"=>$kriteria]);
    }
    public function masukandata($id,Request $request){
        $messages = [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
        ];
        $request->validate([
            'kriteria' => ['required', 'string', 'max:255'],
            'nilai' => ['required', 'numeric','between: 1,100' ],
            'golongan'=>['required'],
        ],$messages);

        SubKriteria::create([
            'id_kriteria'=> $id,
            'nama_sub_kriteria' => $request->kriteria,
            'nilai_perbandingan_sub_kriteria' =>$request->nilai,
            'bobot_sub_kriteria'=>"0",
            'golongan'=>$request->golongan,
        ]);
        $kriteria = SubKriteria::where("id_kriteria",$id)->get();
        $this->HitungBobotSubKriteria($kriteria);

        Alert::success('sukses','Berhasil menginputkan data');
        return redirect(route('sub_kriteria.show',$id));
        // return $request->kriteria;
    }
    public function HitungBobotSubKriteria($kriteria){
        
        $row = 0; 
        $con = 0;
        
        // matriks perbandingan pasangan
        $matriks = array();
        foreach($kriteria as $k){
            $con = 0;
            foreach($kriteria as $kri){
                $matriks[$row][$con] = $k->nilai_perbandingan_sub_kriteria/$kri->nilai_perbandingan_sub_kriteria;
                $con++;
            }
            $row++;
        }

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
        $row=0;
        foreach($kriteria as $k){
            SubKriteria::where('id_sub_kriteria',$k->id_sub_kriteria)->update([
                    "bobot_sub_kriteria"=>$bobot[$row],
            ]);
            $row++;
        }
    }

    public function edit($id){
        $subkriteria = SubKriteria::find($id);
        return view("pages.subkriteria.edit",["id"=>$id,"subkriteria"=>$subkriteria]);
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
            'nilai' => ['required', 'numeric','between: 1,100' ],
            'golongan'=>['required'],
        ],$messages);

        SubKriteria::where("id_sub_kriteria",$id)->update([
            'nama_sub_kriteria' => $request->kriteria,
            'nilai_perbandingan_sub_kriteria' =>$request->nilai,
            'golongan'=>$request->golongan,
        ]);
        $id_kriteria=SubKriteria::find($id);
        $kriteria = SubKriteria::where("id_kriteria",$id_kriteria->id_kriteria)->get();
        $this->HitungBobotSubKriteria($kriteria);

        Alert::success('sukses','Berhasil mengupdate data');
        return redirect(route('sub_kriteria.show',$id_kriteria->id_kriteria));
    }
}
