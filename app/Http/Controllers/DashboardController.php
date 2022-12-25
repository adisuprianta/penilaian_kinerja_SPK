<?php

namespace App\Http\Controllers;

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
        
        $perusahaan = role_user_perusahaan::find(Auth::user()->id);

        $kriteria = Kriteria::get();
        $subkriteria = SubKriteria::get();
        $nilai_kriteria = nilai_kriteria::where('id_user',Auth::user()->id)
        ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'),)
        ->get();
        $nilai_sub_kriteria=nilai_sub_kriteria::where('id_user',Auth::user()->id)
        ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'),)
        ->get();
        // dd($nilai_kriteria);
        $kar = karyawan::where('id_perusahaan',$perusahaan->id_perusahaan)->get();
        $karyawan = DB::table('karyawan as k')
        ->leftJoin('bobot_akhir as b','b.id_karyawan','=','k.id_karyawan')
        ->where('id_perusahaan',$perusahaan->id_perusahaan)
        ->where('tanggal_bobot',Carbon::now()->format('Y-m-d'),)
        ->orderBy('bobot_akhir','desc')
        ->get();
        // dd($karyawan);
        return view('pages.dashboard',['karyawan'=>$karyawan,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'nilai_kriteria'=>$nilai_kriteria,'perusahaan'=>$perusahaan,'jumlah'=>count($kar),'kriteria'=>$kriteria,'subkriteria'=>$subkriteria]);

    }
}
