<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Session;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index(){
        $perusahaan=Perusahaan::get();
        return view('pages.perusahaan.index',['perusahaan'=>$perusahaan]);
    }
    public function create(){
        return view('pages.perusahaan.create');
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
            'nama' => ['required', 'string', 'max:255'],
            'alamat'=>['required','string','max:200'],
        ],$messages);
        $perusahaan=Perusahaan::create([
            'nama_perusahaan'=>$request->nama,
            'alamat_perusahaan'=>$request->alamat,
        ]);

        Session::flash('sukses','Data Perusahaan '.$perusahaan->nama_perusahaan .' berhasil dimasukan');
        return redirect(route('perusahaan.index'));
    }
    public function edit($id){
        $perusahaan = Perusahaan::find($id);
        return view('pages.perusahaan.edit',['perusahaan'=>$perusahaan]);
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
            'nama' => ['required', 'string', 'max:255'],
            'alamat'=>['required','string','max:200'],
        ],$messages);
        $perusahaan=Perusahaan::where('id_perusahaan',$id)->update([
            'nama_perusahaan'=>$request->nama,
            'alamat_perusahaan'=>$request->alamat,
        ]);

        Session::flash('sukses','Data Perusahaan '.$request->nama .' berhasil diubah');
        return redirect(route('perusahaan.index'));
    }
    public function destroy($id){
        $perusahaan=Perusahaan::find($id);
        $perusahaan->delete();
        Session::flash('sukses','Berhasil hapus data perusahaan '.$perusahaan->nama_perusahaan);
        return redirect(route('perusahaan.index'));
    }
}
