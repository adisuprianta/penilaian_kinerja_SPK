<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index($id){
        $karyawan = DB::table('karyawan as k')->select('pk.nama_pangkat','pp.nama_perusahaan','k.*')->join('kontrak_karyawan as kk','k.id_karyawan','=','kk.id_karyawan')->
        join('pangkat_karyawan as pk','k.id_pangkat','=','pk.id_pangkat_karyawan')->
        join('perusahaan_partner as pp', 'k.id_perusahaan','=','pp.id_perusahaan')
        ->where('kk.status','A')->where('pp.id_perusahaan',$id)->get();
        // dd($karyawan);
        $perusahaan = Perusahaan::get();
        
    }
}
