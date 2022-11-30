<?php

namespace App\Http\Controllers;

use App\Models\karyawan;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use Validator;

class KaryawanController extends Controller
{
    public function index(){
        $karyawan=karyawan::get();
        return view('pages.karyawan.index',['karyawan'=>$karyawan]);
    }
    public function create(){
        return view('pages.karyawan.create');
    }
    public function store(Request $request){
        $messages= [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
            'date'=> ':Nilai inputan harus diisi dengan tanggal',
            
        ];
        $request->validate([
            'nama_karyawan' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nohp' => ['required', 'numeric' ],
            'jkel'=> ['required'],
            'alamat'=>['required','string','max:100'],
            // 'tgl_kerja'=>['required','date'],
            'tgl_lahir'=>['required','date'],
            // 'status'=> ['required'],
            // 'berkas'=> ['required|mimes:pdf,docx|max:2048'],
        ],$messages);
    //     $tes= Carbon::parse($request->tgl_lahir)->format('Y-m-d') ;
    //     // dd($tes);
    //    dd(Carbon::parse($tes)->format(config('app.date_format')));
        
    //     dd(Carbon::createFromFormat('m-d-Y', $request->tgl_lahir)->format('Y-M-D'));

        // $current = Carbon::now()->isoFormat('Y-M-D');
        // $berkas = $request->file('berkas');
        // $nama_berkas = $request->nama_karyawan."_Kontrak_Kerja_".$current.".".$berkas->getClientOriginalExtension();
        // // echo $nama_berkas;
        $karyawan = karyawan::create([
            'nama_karyawan' => $request->nama_karyawan,
            'email' => $request->email,
            'no_hp' => $request->nohp,
            'jenis_kelamin'=> $request->jkel,
            'alamat'=>$request->alamat,
            'tanggal_lahir'=> Carbon::parse($request->tgl_lahir)->format('Y-m-d'),
        ]);
        // dd($karyawan);
        // // $berkas->move(public_path().'/berkas_kontrak',$nama_berkas);
        Session::flash('sukses','Berhasil menginputkan data');
        return redirect(route('karyawan.index'));
    }
}
