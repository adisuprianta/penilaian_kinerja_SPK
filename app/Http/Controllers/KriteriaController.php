<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use Session;
class KriteriaController extends Controller
{
    public function index(){
        $kriteria = Kriteria::get();
        return view('pages.kriteria.index',['kriteria'=>$kriteria]);
    }
    public function create(){
        return view('pages.kriteria.create');
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
            'nilai' => ['required', 'numeric','between: 1,100' ],
        ],$messages);

        Kriteria::create([
            'nama_kriteria' => $request->kriteria,
            'nilai_perbandingan_kriteria' =>$request->nilai,
            'bobot_kriteria'=>"0",
        ]);
        $this->HitungBobotKriteria();

        Session::flash('sukses','Berhasil menginputkan data');
        return redirect('/kriteria');
    }

    public function HitungBobotKriteria(){
        $kriteria = Kriteria::get();
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
            Kriteria::where('id_kriteria',$k->id_kriteria)->update([
                    "bobot_kriteria"=>$bobot[$row],
            ]);
            $row++;
        }
    }
}
