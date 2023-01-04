<?php

namespace App\Http\Controllers;

use App\Models\bobot_akhir;
use App\Models\bobot_kriteria;
use App\Models\bobot_sub_kriteria;
use App\Models\karyawan;
use App\Models\Kriteria;
use App\Models\nilai_kriteria;
use App\Models\nilai_sub_kriteria;
use App\Models\Perusahaan;
use App\Models\role_user_perusahaan;
use App\Models\SubKriteria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        // dd(Auth::user()->perusahaan->id_perusahaan);
        if(Auth::user()->hasRole('user') ){
            $perusahaan = role_user_perusahaan::find(Auth::user()->id);

            $kriteria = Kriteria::get();
            $subkriteria = SubKriteria::get();
            $nilai_kriteria = nilai_kriteria::where('bk.id_user',Auth::user()->id)->select('id_kriteria','id_karyawan',bobot_kriteria::raw('avg(bobot_kriteria) as nilai_kriteria'))->
            join('bobot_kriteria as bk','bk.id_nilai_kriteria','=','nilai_kriteria.id_nilai_kriteria')->
            // select('id_kriteria','id_karyawan')
            // ->groupBy('id_karyawan')->get()
            where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
            ->groupBy('id_karyawan','id_kriteria')->get(); 
            $nilai_sub_kriteria=nilai_sub_kriteria::where('bsk.id_user',Auth::user()->id)->select('id_sub_kriteria','id_karyawan',bobot_sub_kriteria::raw('avg(bobot_kriteria) as nilai_sub_kriteria'))->
            join('bobot_sub_kriteria as bsk','bsk.id_nilai_sub_kriteria','=','nilai_sub_kriteria.id_nilai_sub_kriteria')->
            where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
            ->groupBy('id_karyawan','id_sub_kriteria')
            ->get();
            // dd($nilai_kriteria);
            $kar = karyawan::where('id_perusahaan',$perusahaan->id_perusahaan)->get();
            
            $karyawan = DB::table('karyawan as k')
            ->leftJoin('bobot_akhir as b','b.id_karyawan','=','k.id_karyawan')
            ->join('perusahaan_partner as pn','pn.id_perusahaan','=','k.id_perusahaan')
            ->where('id_user',Auth::user()->id)
            ->where('pn.id_perusahaan',$perusahaan->id_perusahaan)
            ->where('tanggal_bobot',Carbon::now()->format('Y-m-d'))
            ->orderBy('bobot_akhir','desc')
            ->get();
            $terbaik = DB::table('karyawan as k')
            ->leftJoin('bobot_akhir as b','b.id_karyawan','=','k.id_karyawan')
            ->where('id_perusahaan',$perusahaan->id_perusahaan)
            ->where('id_user',Auth::user()->id)
            ->where('tanggal_bobot',Carbon::now()->format('Y-m-d'))
            ->orderBy('bobot_akhir','desc')
            ->first();
            // dd($ni);
        }elseif(Auth::user()->hasRole('team_leader')){
            $perusahaan = role_user_perusahaan::find(Auth::user()->id);

            $kriteria = Kriteria::get();
            $subkriteria = SubKriteria::get();
            $nilai_kriteria = nilai_kriteria::where('id_user',Auth::user()->id)->select('id_kriteria','id_karyawan',bobot_kriteria::raw('avg(bobot_kriteria) as nilai_kriteria'))->
            join('bobot_kriteria as bk','bk.id_nilai_kriteria','=','nilai_kriteria.id_nilai_kriteria')->
            // select('id_kriteria','id_karyawan')
            // ->groupBy('id_karyawan')->get()
            where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
            ->groupBy('id_karyawan','id_kriteria')->get(); 
            $nilai_sub_kriteria=nilai_sub_kriteria::where('id_user',Auth::user()->id)
            ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
            ->get();
            // dd($nilai_kriteria);
            $kar = karyawan::where('id_perusahaan',$perusahaan->id_perusahaan)->get();
            
            $karyawan = DB::table('karyawan as k')
            ->leftJoin('bobot_akhir as b','b.id_karyawan','=','k.id_karyawan')
            ->join('perusahaan_partner as pn','pn.id_perusahaan','=','k.id_perusahaan')
            ->where('id_user',Auth::user()->id)
            ->where('pn.id_perusahaan',$perusahaan->id_perusahaan)
            ->where('tanggal_bobot',Carbon::now()->format('Y-m-d'))
            ->orderBy('bobot_akhir','desc')
            ->get();
            $terbaik = DB::table('karyawan as k')
            ->leftJoin('bobot_akhir as b','b.id_karyawan','=','k.id_karyawan')
            ->where('id_perusahaan',$perusahaan->id_perusahaan)
            ->where('id_user',Auth::user()->id)
            ->where('tanggal_bobot',Carbon::now()->format('Y-m-d'))
            ->orderBy('bobot_akhir','desc')
            ->first();
        }
        else{
            // $perusahaan = role_user_perusahaan::find(Auth::user()->id);
            
            $kriteria = Kriteria::get();
            $subkriteria = SubKriteria::get();
            $nilai_kriteria = nilai_kriteria::select('id_kriteria','id_karyawan',bobot_kriteria::raw('avg(bobot_kriteria) as nilai_kriteria'))->
            join('bobot_kriteria as bk','bk.id_nilai_kriteria','=','nilai_kriteria.id_nilai_kriteria')->
            // select('id_kriteria','id_karyawan')
            // ->groupBy('id_karyawan')->get()
            where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
            ->groupBy('id_karyawan','id_kriteria')->get();
            // dd($nilai_kriteria);
            // ->avg('nilai_kriteria');
            $nilai_sub_kriteria=nilai_sub_kriteria::
            select('id_sub_kriteria','id_karyawan',bobot_sub_kriteria::raw('avg(bobot_kriteria) as nilai_sub_kriteria'))->
            join('bobot_sub_kriteria as bsk','bsk.id_nilai_sub_kriteria','=','nilai_sub_kriteria.id_nilai_sub_kriteria')->
            where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
            ->groupBy('id_karyawan','id_sub_kriteria')
            ->get();
            // dd($nilai_sub_kriteria);
            $kar = karyawan::get();
            
            $karyawan = DB::table('karyawan as k')->select(bobot_akhir::raw('avg(bobot_akhir) as bobot_akhir'),'b.id_karyawan','k.nama_karyawan','id_pangkat','nama_perusahaan')
            ->join('bobot_akhir as b','b.id_karyawan','=','k.id_karyawan')
            ->join('perusahaan_partner as pn','pn.id_perusahaan','=','k.id_perusahaan')
            ->where('tanggal_bobot',Carbon::now()->format('Y-m-d'))
            ->orderBy('bobot_akhir','desc')->groupBy('id_karyawan','nama_karyawan','id_pangkat','nama_perusahaan')
            ->get();
            // dd($karyawan);  
            $terbaik = DB::table('karyawan as k')
            ->join('bobot_akhir as b','b.id_karyawan','=','k.id_karyawan')
            ->where('tanggal_bobot',Carbon::now()->format('Y-m-d'))
            ->orderBy('bobot_akhir','desc')
            ->first();
            
        }
        
        // $terakhir = DB::table('karyawan as k')
        // ->leftJoin('bobot_akhir as b','b.id_karyawan','=','k.id_karyawan')
        // ->where('id_perusahaan',$perusahaan->id_perusahaan)
        // ->where('tanggal_bobot',Carbon::now()->format('Y-m-d'),)
        // ->orderBy('bobot_akhir','asc')
        // ->first();
        // foreach($karyawan as $kar){
        //     dd($ka);
        // }
        // dd($karyawan);
        // dd($terbaik);
        return view('pages.dashboard',['terbaik'=>$terbaik,'karyawan'=>$karyawan,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'nilai_kriteria'=>$nilai_kriteria,'jumlah'=>count($kar),'kriteria'=>$kriteria,'subkriteria'=>$subkriteria]);

    }
}
