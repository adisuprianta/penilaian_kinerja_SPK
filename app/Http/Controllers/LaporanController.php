<?php

namespace App\Http\Controllers;

use App\Models\bobot_akhir;
use App\Models\bobot_kriteria;
use App\Models\bobot_sub_kriteria;
use App\Models\karyawan;
use App\Models\Kriteria;
use App\Models\nilai_kriteria;
use App\Models\nilai_sub_kriteria;
use App\Models\SubKriteria;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class LaporanController extends Controller
{
    public function show($id){
        
        $min = Carbon::now()->format('Y-m-d');
        $max = Carbon::now()->format('Y-m-d');
        if($id==2){
            
            $kriteria = Kriteria::where('id_pangkat',$id)->get();
            $con = new KriteriaController();
            $con->HitungBobotKriteria($kriteria);
            $kriteria = Kriteria::where('id_pangkat',$id)->get();
        }else{
            $kriteria = Kriteria::get();
            $con = new KriteriaController();
            $con->HitungBobotKriteria($kriteria);
            $kriteria = Kriteria::get();
        }
        // $kriteria = Kriteria::get();
        $subkriteria = SubKriteria::get();
        $nilai_kriteria = nilai_kriteria::select('id_kriteria','id_pangkat','nilai_kriteria.id_karyawan',bobot_kriteria::raw('avg(bobot_kriteria) as nilai_kriteria'))->
        join('bobot_kriteria as bk','bk.id_nilai_kriteria','=','nilai_kriteria.id_nilai_kriteria')
        ->join('karyawan as k','k.id_karyawan','=','nilai_kriteria.id_karyawan')
        ->where('id_pangkat', $id)
        // select('id_kriteria','id_karyawan')
        // ->groupBy('id_karyawan')->get()
        ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
        ->groupBy('id_karyawan','id_kriteria','id_pangkat')->get();
        // dd($nilai_kriteria);
        // ->avg('nilai_kriteria');
        $nilai_sub_kriteria=nilai_sub_kriteria::
        select('id_sub_kriteria','id_pangkat','nilai_sub_kriteria.id_karyawan',bobot_sub_kriteria::raw('avg(bobot_kriteria) as nilai_sub_kriteria'))->
        join('bobot_sub_kriteria as bsk','bsk.id_nilai_sub_kriteria','=','nilai_sub_kriteria.id_nilai_sub_kriteria')
        ->join('karyawan as k','k.id_karyawan','=','nilai_sub_kriteria.id_karyawan')
        ->where('id_pangkat', $id)
        ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
        ->groupBy('id_karyawan','id_sub_kriteria','id_pangkat')
        ->get();
        // dd($nilai_sub_kriteria);
        
        $karyawan = DB::table('karyawan as k')->select(bobot_akhir::raw('avg(bobot_akhir) as bobot_akhir'),'b.id_karyawan','k.nama_karyawan','id_pangkat','nama_perusahaan')
        ->join('bobot_akhir as b','b.id_karyawan','=','k.id_karyawan')
        ->join('perusahaan_partner as pn','pn.id_perusahaan','=','k.id_perusahaan')
        ->where('tanggal_bobot',Carbon::now()->format('Y-m-d'))
        ->where('id_pangkat', $id)
        ->orderBy('bobot_akhir','desc')->groupBy('id_karyawan','nama_karyawan','id_pangkat','nama_perusahaan')
        ->get();
        // dd($karyawan);  
        
        // dd($max);
        return view('pages.laporan.index',['min'=>$min,'id'=>$id,'max'=>$max,'karyawan'=>$karyawan,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'nilai_kriteria'=>$nilai_kriteria,'kriteria'=>$kriteria,'subkriteria'=>$subkriteria]);

    }

    public function date_range(Request $request){
        $id=$request->id;
        // if($request->form_date == null){
            // dd($request->all());
        // }
        
        // dd(1);
        if($id==2){
            
            $kriteria = Kriteria::where('id_pangkat',$id)->get();
            $con = new KriteriaController();
            $con->HitungBobotKriteria($kriteria);
        }else{
            $kriteria = Kriteria::get();
            $con = new KriteriaController();
            $con->HitungBobotKriteria($kriteria);
            
        }
        $subkriteria = SubKriteria::get();
        if($request->from_date == null && $request->to_date == null){
            // dd(1);
            $min = Carbon::now()->format('Y-m-d');
            $max = Carbon::now()->format('Y-m-d');
            // $subkriteria = SubKriteria::get();
            $nilai_kriteria = nilai_kriteria::select('id_kriteria','id_pangkat','nilai_kriteria.id_karyawan',bobot_kriteria::raw('avg(bobot_kriteria) as nilai_kriteria'))->
            join('bobot_kriteria as bk','bk.id_nilai_kriteria','=','nilai_kriteria.id_nilai_kriteria')
            ->join('karyawan as k','k.id_karyawan','=','nilai_kriteria.id_karyawan')
            ->where('id_pangkat', $id)
            // select('id_kriteria','id_karyawan')
            // ->groupBy('id_karyawan')->get()
            ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
            ->groupBy('id_karyawan','id_kriteria','id_pangkat')->get();
            // dd($nilai_kriteria);
            // ->avg('nilai_kriteria');
            $nilai_sub_kriteria=nilai_sub_kriteria::
            select('id_sub_kriteria','id_pangkat','nilai_sub_kriteria.id_karyawan',bobot_sub_kriteria::raw('avg(bobot_kriteria) as nilai_sub_kriteria'))->
            join('bobot_sub_kriteria as bsk','bsk.id_nilai_sub_kriteria','=','nilai_sub_kriteria.id_nilai_sub_kriteria')
            ->join('karyawan as k','k.id_karyawan','=','nilai_sub_kriteria.id_karyawan')
            ->where('id_pangkat', $id)
            ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
            ->groupBy('id_karyawan','id_sub_kriteria','id_pangkat')
            ->get();
            // dd($nilai_sub_kriteria);
            
            $karyawan = DB::table('karyawan as k')->select(bobot_akhir::raw('avg(bobot_akhir) as bobot_akhir'),'b.id_karyawan','k.nama_karyawan','id_pangkat','nama_perusahaan')
            ->join('bobot_akhir as b','b.id_karyawan','=','k.id_karyawan')
            ->join('perusahaan_partner as pn','pn.id_perusahaan','=','k.id_perusahaan')
            ->where('tanggal_bobot',Carbon::now()->format('Y-m-d'))
            ->where('id_pangkat', $id)
            ->orderBy('bobot_akhir','desc')->groupBy('id_karyawan','nama_karyawan','id_pangkat','nama_perusahaan')
            ->get();
                
        }else{
            // $kriteria = Kriteria::get();
            // $subkriteria = SubKriteria::get();
            $min = $request->form_date;
            $max = $request->to_date;
            $karyawan = DB::table('karyawan as k')->select(bobot_akhir::raw('avg(bobot_akhir) as bobot_akhir'),'b.id_karyawan','k.nama_karyawan','id_pangkat','nama_perusahaan')
            ->join('bobot_akhir as b','b.id_karyawan','=','k.id_karyawan')
            ->join('perusahaan_partner as pn','pn.id_perusahaan','=','k.id_perusahaan')
            ->whereBetween('tanggal_bobot',array($min, $max))
            ->orderBy('bobot_akhir','desc')->groupBy('id_karyawan','nama_karyawan','id_pangkat','nama_perusahaan')
            ->get();
            $nilai_kriteria = nilai_kriteria::select('id_kriteria','nilai_kriteria.id_karyawan',bobot_kriteria::raw('avg(bobot_kriteria) as nilai_kriteria'))->
            join('bobot_kriteria as bk','bk.id_nilai_kriteria','=','nilai_kriteria.id_nilai_kriteria')
            ->join('karyawan as k','k.id_karyawan','=','nilai_kriteria.id_karyawan')
            ->where('id_pangkat', $id)
            ->whereBetween('tanggal_nilai',array($min, $max))
            ->groupBy('id_karyawan','id_kriteria')->get();
            // dd($nilai_kriteria);
            // ->avg('nilai_kriteria');
            $nilai_sub_kriteria=nilai_sub_kriteria::
            select('id_sub_kriteria','nilai_sub_kriteria.id_karyawan',bobot_sub_kriteria::raw('avg(bobot_kriteria) as nilai_sub_kriteria'))->
            join('bobot_sub_kriteria as bsk','bsk.id_nilai_sub_kriteria','=','nilai_sub_kriteria.id_nilai_sub_kriteria')
            ->join('karyawan as k','k.id_karyawan','=','nilai_sub_kriteria.id_karyawan')
            ->where('id_pangkat', $id)->
            whereBetween('tanggal_nilai',array($min, $max))
            ->groupBy('id_karyawan','id_sub_kriteria')
            ->get();
            // dd($karyawan);
            
        }
        return view('pages.laporan.index',['id'=>$id,'min'=>$min,'max'=>$max,'karyawan'=>$karyawan,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'nilai_kriteria'=>$nilai_kriteria,'kriteria'=>$kriteria,'subkriteria'=>$subkriteria]);    
        
    }
    public function cetak_pdf(Request $request ){
        $id=$request->id;
        if($id==2){
            
            $kriteria = Kriteria::where('id_pangkat',$id)->get();
            $con = new KriteriaController();
            $con->HitungBobotKriteria($kriteria);
        }else{
            $kriteria = Kriteria::get();
            $con = new KriteriaController();
            $con->HitungBobotKriteria($kriteria);
            
        }
        $subkriteria = SubKriteria::get();
        if($request->from_date == null && $request->to_date == null){
            $min = Carbon::now()->format('Y-m-d');
            $max = Carbon::now()->format('Y-m-d');
        }else{
            $min = $request->form_date;
            $max = $request->to_date;
        }
        
        $karyawan = DB::table('karyawan as k')->select(bobot_akhir::raw('avg(bobot_akhir) as bobot_akhir'),'b.id_karyawan','k.nama_karyawan','id_pangkat','nama_perusahaan')
            ->join('bobot_akhir as b','b.id_karyawan','=','k.id_karyawan')
            ->join('perusahaan_partner as pn','pn.id_perusahaan','=','k.id_perusahaan')
            ->whereBetween('tanggal_bobot',array($min, $max))
            ->orderBy('bobot_akhir','desc')->groupBy('id_karyawan','nama_karyawan','id_pangkat','nama_perusahaan')
            ->get();
            $nilai_kriteria = nilai_kriteria::select('id_kriteria','nilai_kriteria.id_karyawan',bobot_kriteria::raw('avg(bobot_kriteria) as nilai_kriteria'))->
            join('bobot_kriteria as bk','bk.id_nilai_kriteria','=','nilai_kriteria.id_nilai_kriteria')
            ->join('karyawan as k','k.id_karyawan','=','nilai_kriteria.id_karyawan')
            ->where('id_pangkat', $id)
            ->whereBetween('tanggal_nilai',array($min, $max))
            ->groupBy('id_karyawan','id_kriteria')->get();
            // dd($nilai_kriteria);
            // ->avg('nilai_kriteria');
            $nilai_sub_kriteria=nilai_sub_kriteria::
            select('id_sub_kriteria','nilai_sub_kriteria.id_karyawan',bobot_sub_kriteria::raw('avg(bobot_kriteria) as nilai_sub_kriteria'))->
            join('bobot_sub_kriteria as bsk','bsk.id_nilai_sub_kriteria','=','nilai_sub_kriteria.id_nilai_sub_kriteria')
            ->join('karyawan as k','k.id_karyawan','=','nilai_sub_kriteria.id_karyawan')
            ->where('id_pangkat', $id)->
            whereBetween('tanggal_nilai',array($min, $max))
            ->groupBy('id_karyawan','id_sub_kriteria')
            ->get();
        // dd(1);
        $pdf= PDF::loadview('pages.laporan.index_pdf',['id'=>$id,'min'=>$min,'max'=>$max,'karyawan'=>$karyawan,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'nilai_kriteria'=>$nilai_kriteria,'kriteria'=>$kriteria,'subkriteria'=>$subkriteria])->setPaper('a4', 'landscape');
        // return view('pages.laporan.index_pdf',['min'=>$min,'max'=>$max,'karyawan'=>$karyawan,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'nilai_kriteria'=>$nilai_kriteria,'kriteria'=>$kriteria,'subkriteria'=>$subkriteria]);
        return $pdf->download('Laporan-Kinerja-Karyawan.pdf');
        // $karyawan=karyawan::join('pangkat_karyawan','id_pangkat','=','id_pangkat_karyawan')->join('perusahaan_partner as p', 'p.id_perusahaan','=','karyawan.id_perusahaan')->get();
        // $pdf= PDF::loadview('pages.laporan.te',['karyawan'=>$karyawan])->setPaper('a4', 'landscape');
        // set_time_limit(300);
        // // return view('pages.laporan.te',['karyawan'=>$karyawan]);    
        // return $pdf->download('te.pdf');
    }
}
