<?php

namespace App\Http\Controllers;

use App\Models\karyawan;
use App\Models\Kontrak_kerja;
use App\Models\Pangkat_karyawan;
use App\Models\Pekerjaan;
use App\Models\Pekerjaan_karyawan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use Database\Seeders\PangkatSeeder;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

class KaryawanController extends Controller
{
    // public function show($id){
    //     // return "a";
    //     $karyawan=karyawan::select('nama_karyawan')->find($id);
    //     $pekerjaan = Pekerjaan_karyawan::get();
    //     return view("pages.pekerjaan_karyawan.index",["id"=>$id,"pekerjaan"=>$pekerjaan,'karyawan'=>$karyawan]);
    // }
    public function index(){
        $karyawan=karyawan::join('pangkat_karyawan','id_pangkat','=','id_pangkat_karyawan')->join('perusahaan_partner as p', 'p.id_perusahaan','=','karyawan.id_perusahaan')->get();
        return view('pages.karyawan.index',['karyawan'=>$karyawan]);
    }
    public function destroy($id){
        $karyawan = karyawan::find($id);
        $karyawan->delete();
        Alert::success('sukses','Berhasil menghapus data');
        return redirect(route('karyawan.index'));
    }
    public function create(){
        
        $perusahaan= Perusahaan::get();
        $pangkat = Pangkat_karyawan::get();
        return view('pages.karyawan.create',["perusahaan"=>$perusahaan,"pangkat"=>$pangkat]);
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:karyawan'],
            'nohp' => ['required', 'numeric' ],
            'jkel'=> ['required'],
            'alamat'=>['required','string','max:200'],
            'perusahaan'=>['required'],
            'pangkat'=>['required'],
            // 'tgl_kerja'=>['required','date'],
            'tgl_lahir'=>['required','date'],
            // 'status'=> ['required'],
            // 'berkas'=> ['required|mimes:pdf,docx|max:2048'],
        ],$messages);
        // dd($request->all());
    //     $tes= Carbon::parse($request->tgl_lahir)->format('Y-m-d') ;
    //     // dd($tes);
    //    dd(Carbon::parse($tes)->format(config('app.date_format')));
        
    //     dd(Carbon::createFromFormat('m-d-Y', $request->tgl_lahir)->format('Y-M-D'));

        $current = Carbon::now()->isoFormat('Y-M-D');
        // $berkas = $request->file('berkas');
        // $nama_berkas = $request->nama_karyawan."_Kontrak_Kerja_".$current.".".$berkas->getClientOriginalExtension();
        // // echo $nama_berkas;
        // dd(Carbon::now()->addMonths(4)->format('Y-m-d'));
        // dd($request->perusahaan);
        $karyawan = karyawan::create([
            'nama_karyawan' => $request->nama_karyawan,
            'id_pangkat'=>$request->pangkat,
            'email' => $request->email,
            'no_hp' => $request->nohp,
            'jenis_kelamin'=> $request->jkel,
            'id_perusahaan'=>$request->perusahaan,
            'alamat'=>$request->alamat,
            'tanggal_lahir'=> Carbon::parse($request->tgl_lahir)->format('Y-m-d'),
        ]);
        // Kontrak_kerja::create([
        //     'id_karyawan'=>$karyawan->id_karyawan,
        //     'tanggal_masuk'=>Carbon::now()->format('Y-m-d'),
        //     'tanggal_kerja'=>Carbon::parse($request->tgl_kerja)->format('Y-m-d'),
        //     'berkas_kontrak'=>$nama_berkas,
        //     'status'=>$request->status
        // ]);
        // dd($karyawan);
        // $berkas->move(public_path().'/berkas_kontrak',$nama_berkas);
        Alert::success('sukses','Berhasil menginputkan data');
        return redirect(route('karyawan.index'));
    }
    public function edit($id){
        $pangkat = Pangkat_karyawan::get();
        $karyawan= karyawan::find($id);
        $perusahaan=Perusahaan::get();
        return view("pages.karyawan.edit",["karyawan"=>$karyawan,"pangkat"=>$pangkat,'perusahaan'=>$perusahaan]);
    }
    public function update($id,Request $request){
        
        $messages= [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
            'date'=> ':Nilai inputan harus diisi dengan tanggal',
        ];
        
        $request->validate([
            'nama_karyawan' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'nohp' => ['required', 'numeric' ],
            'jkel'=> ['required'],
            'alamat'=>['required','string','max:200'],
            'perusahaan'=>['required'],
            'pangkat'=>['required'],
            'tgl_lahir'=>['required','date'],
        ],$messages);
        // dd($request->all());
        karyawan::where('id_karyawan',$id)->update([
            'nama_karyawan' => $request->nama_karyawan,
            'id_pangkat'=>$request->pangkat,
            'email' => $request->email,
            'id_perusahaan'=>$request->perusahaan,
            'no_hp' => $request->nohp,
            'jenis_kelamin'=> $request->jkel,
            'alamat'=>$request->alamat,
            'tanggal_lahir'=> Carbon::parse($request->tgl_lahir)->format('Y-m-d'),
        ]);
        Alert::success('sukses','Berhasil mengupdate data '.$request->nama_karyawan);
        return redirect(route('karyawan.index'));
    }
}
