<?php

namespace App\Http\Controllers;


use App\Models\Pekerjaan_karyawan;
use Illuminate\Http\Request;
use Session;

class PekerjaanController extends Controller
{
    public function create($id){
        return  view("pages.pekerjaan_karyawan.create",['id'=>$id]);
    }
    public function store($id,Request $request){
        $messages= [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
            'date'=> ':Nilai inputan harus diisi dengan tanggal',
            
        ];
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
        ],$messages);

        Pekerjaan_karyawan::create([
            'nama_pekerjaan'=>$request->nama,
            'id_karyawan'=>$id
        ]);
        return redirect(route('karyawan.show',$id));
    }
    public function update($id, Request $request){
        $messages= [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
            'date'=> ':Nilai inputan harus diisi dengan tanggal',
            
        ];
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
        ],$messages);
        $pekerjaan = Pekerjaan_karyawan::find($id);
        Pekerjaan_karyawan::where('id_pekerjaan',$id)->update([
            'nama_pekerjaan'=>$request->nama,
            'id_karyawan'=>$id
        ]);
        return redirect(route('karyawan.show',$pekerjaan->id_karyawan));
    }
    public function edit($id){
        $pekerjaan = Pekerjaan_karyawan::find($id);
        return view("pages.pekerjaan_karyawan.edit",['pekerjaan'=>$pekerjaan]);
    }
    public function destroy($id){
        $pekerjaan=Pekerjaan_karyawan::find($id);
        // dd($pekerjaan);
        $pekerjaan->delete();
        Session::flash('sukses','Berhasil menghapus data data '.$pekerjaan->nama_pekerjaan);
        return redirect()->back();
    }
}
