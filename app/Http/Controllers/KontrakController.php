<?php

namespace App\Http\Controllers;

use App\Models\karyawan;
use App\Models\Kontrak_kerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;

class KontrakController extends Controller
{
    public function index(){
        $kontrak = DB::table('karyawan as k')->select('k.nama_karyawan','k.id_karyawan as id','kn.*')->
        leftJoin('kontrak_karyawan as kn','k.id_karyawan','=','kn.id_karyawan')->get();
        
        // dd($kontrak);
        return view('pages.kontrak.index',['kontrak'=>$kontrak]);
    }
    public function create($id){
        $karyawan=karyawan::find($id);
        return view('pages.kontrak.create',['karyawan'=>$karyawan,'id'=>$id]);
    }
    public function store($id, Request $request){
        $messages= [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
            'date'=> ':Nilai inputan harus diisi dengan tanggal',
            
        ];
        $request->validate([
            
            'tgl_kerja'=>['required','date'],
            'status'=> ['required'],
            'berkas'=> ['required','mimes:pdf,docx','max:2048'],
        ],$messages);
        // dd(1);
        $current = Carbon::now()->isoFormat('Y-M-D');
        $berkas = $request->file('berkas');
        $nama_berkas = $request->nama_karyawan."_Kontrak_Kerja_".$current.".".$berkas->getClientOriginalExtension();
        Kontrak_kerja::create([
            'id_karyawan'=>$id,
            'tanggal_masuk'=>Carbon::now()->format('Y-m-d'),
            'tanggal_kerja'=>Carbon::parse($request->tgl_kerja)->format('Y-m-d'),
            'berkas_kontrak'=>$nama_berkas,
            'status'=>$request->status
        ]);
        $berkas->move(public_path().'/berkas_kontrak',$nama_berkas);
        Session::flash('sukses','Berhasil menginputkan data');
        return redirect(route('kontrak.index'));
    }
}
