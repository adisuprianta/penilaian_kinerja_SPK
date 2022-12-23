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

class PenilaianController extends Controller
{
    public function index(){
        $perusahaan = role_user_perusahaan::find(Auth::user()->id);
        // dd($perusahaan);
        if(Auth::user()->hasRole('manajer')  ){
            $karyawan = DB::table('karyawan as k')
            ->select('pk.nama_pangkat','pp.nama_perusahaan','k.id_karyawan','k.nama_karyawan','k.jenis_kelamin')
            ->join('kontrak_karyawan as kk','k.id_karyawan','=','kk.id_karyawan')->
            join('pangkat_karyawan as pk','k.id_pangkat','=','pk.id_pangkat_karyawan')->
            join('perusahaan_partner as pp', 'k.id_perusahaan','=','pp.id_perusahaan')
            ->where('kk.status','A')->where('pp.id_perusahaan',$perusahaan->id_perusahaan)
            ->where('k.id_pangkat','1')
            ->get();
            // ->groupBy('k.id_pangkat','k.id_karyawan','k.id_perusahaan','k.nama_karyawan','k.email','k.no_hp','k.jenis_kelamin','k.alamat','k.tanggal_lahir','k.created_at','k.updated_at')
            // ->leftJoin('nilai_sub_kriteria as ns','k.id_karyawan','=','ns.id_karyawan')
            $tanggal = Carbon::now()->format('Y-m-d');
            $nilai_kriteria = nilai_kriteria::where('id_user',Auth::user()->id)
            ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
            ->get();
            $nilai_sub_kriteria=nilai_sub_kriteria::where('id_user',Auth::user()->id)
            ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'))->get();
            // dd($karyawan);
            // dd($nilai_kriteria);
            // $perusahaan = Perusahaan::get();
        }elseif(Auth::user()->hasRole('user')){
            $karyawan = DB::table('karyawan as k')
            ->select('pk.nama_pangkat','pp.nama_perusahaan','k.id_karyawan','k.nama_karyawan','k.jenis_kelamin')
            ->join('kontrak_karyawan as kk','k.id_karyawan','=','kk.id_karyawan')->
            join('pangkat_karyawan as pk','k.id_pangkat','=','pk.id_pangkat_karyawan')->
            join('perusahaan_partner as pp', 'k.id_perusahaan','=','pp.id_perusahaan')
            
            ->where('kk.status','A')->where('pp.id_perusahaan',$perusahaan->id_perusahaan)
            
        
            ->get();
            // ->groupBy('k.id_pangkat','k.id_karyawan','k.id_perusahaan','k.nama_karyawan','k.email','k.no_hp','k.jenis_kelamin','k.alamat','k.tanggal_lahir','k.created_at','k.updated_at')
            // ->leftJoin('nilai_sub_kriteria as ns','k.id_karyawan','=','ns.id_karyawan')
            $tanggal = Carbon::now()->format('Y-m-d');
            $nilai_kriteria = nilai_kriteria::where('id_user',Auth::user()->id)
            ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
            ->get();
            $nilai_sub_kriteria=nilai_sub_kriteria::where('id_user',Auth::user()->id)
            ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'))->get();
            // dd($karyawan);
            // dd($nilai_kriteria);
            // $perusahaan = Perusahaan::get();
        }elseif(Auth::user()->hasRole('team_leader')){
            $karyawan = DB::table('karyawan as k')
            ->select('pk.nama_pangkat','pp.nama_perusahaan','k.id_karyawan','k.nama_karyawan','k.jenis_kelamin')
            ->join('kontrak_karyawan as kk','k.id_karyawan','=','kk.id_karyawan')->
            join('pangkat_karyawan as pk','k.id_pangkat','=','pk.id_pangkat_karyawan')->
            join('perusahaan_partner as pp', 'k.id_perusahaan','=','pp.id_perusahaan')
            ->where('k.id_pangkat','2')
            ->where('kk.status','A')->where('pp.id_perusahaan',$perusahaan->id_perusahaan)        
            ->get();
            // ->groupBy('k.id_pangkat','k.id_karyawan','k.id_perusahaan','k.nama_karyawan','k.email','k.no_hp','k.jenis_kelamin','k.alamat','k.tanggal_lahir','k.created_at','k.updated_at')
            // ->leftJoin('nilai_sub_kriteria as ns','k.id_karyawan','=','ns.id_karyawan')
            $tanggal = Carbon::now()->format('Y-m-d');
            $nilai_kriteria = nilai_kriteria::where('id_user',Auth::user()->id)
            ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'))
            ->get();
            $nilai_sub_kriteria=nilai_sub_kriteria::where('id_user',Auth::user()->id)
            ->where('tanggal_nilai',Carbon::now()->format('Y-m-d'))->get();
            // dd($karyawan);
            // dd($nilai_kriteria);
            
        }
        
        
        return view('pages.penilaian.index',['id_perusahaan'=>$perusahaan->id_perusahaan,'nilai_kriteria'=>$nilai_kriteria,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'perusahaan'=>$perusahaan,'karyawan'=>$karyawan,'tanggal'=>$tanggal]);
    }
    public function create($id){
        $karyawan = karyawan::find($id);
        if($karyawan->id_pangkat==2){
            $kriteria = Kriteria::where('id_pangkat',$karyawan->id_pangkat)->get();
        }else{
            $kriteria = Kriteria::get();
        }
        // dd($karyawan);
        $subkriteria = SubKriteria::get();
        $perusahaan = role_user_perusahaan::find(Auth::user()->id);
        return view('pages.penilaian.create',['karyawan'=>$karyawan,'id'=>$id,'perusahaan'=>$perusahaan,'subkriteria'=>$subkriteria,'kriteria'=>$kriteria]);
    }
    public function store(Request $request,$id){
        $messages= [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
            'date'=> ':Nilai inputan harus diisi dengan tanggal',
            
        ];
        $request->validate([
            '*' => 'required',
        ],$messages);
        $karyawan = karyawan::find($id);
        if($karyawan->id_pangkat ===2){
            $kriteria = Kriteria::where('id_pangkat','2')
            ->get();
            $subkriteria = SubKriteria::get();         
            foreach($kriteria as $k){
                $no=0;
                foreach($subkriteria as $sk){
                    if($k->id_kriteria == $sk->id_kriteria){
                        $namasub = "namasub".$sk->id_sub_kriteria;
                        echo $request->$namasub;
                        nilai_sub_kriteria::create([
                            'id_user'=>Auth::user()->id,
                            'id_karyawan'=> $id,
                            'id_sub_kriteria'=>$sk->id_sub_kriteria,
                            'tanggal_nilai'=>Carbon::now()->format('Y-m-d'),
                            'nilai_sub_kriteria'=> $request->$namasub,
                        ]);
                        $no=$k->id_kriteria;
                    }
                    
                }
                echo "<br>";
                if($k->id_kriteria == $no){
                    
                }else{
                    $nama= "nama".$k->id_kriteria;
                    // echo $request->$nama;
                    nilai_kriteria::create([
                                'id_user'=>Auth::user()->id,
                                'id_karyawan'=> $id,
                                'id_kriteria'=>$k->id_kriteria,
                                'tanggal_nilai'=>Carbon::now()->format('Y-m-d'),
                                'nilai_kriteria'=> $request->$nama,
                    ]);
                }
            
            }
        }else{
            $kriteria = Kriteria::get();
            $subkriteria = SubKriteria::get();         
            foreach($kriteria as $k){
                $no=0;
                foreach($subkriteria as $sk){
                    if($k->id_kriteria == $sk->id_kriteria){
                        $namasub = "namasub".$sk->id_sub_kriteria;
                        echo $request->$namasub;
                        nilai_sub_kriteria::create([
                            'id_user'=>Auth::user()->id,
                            'id_karyawan'=> $id,
                            'id_sub_kriteria'=>$sk->id_sub_kriteria,
                            'tanggal_nilai'=>Carbon::now()->format('Y-m-d'),
                            'nilai_sub_kriteria'=> $request->$namasub,
                        ]);
                        $no=$k->id_kriteria;
                    }
                    
                }
                echo "<br>";
                if($k->id_kriteria == $no){
                    
                }else{
                    $nama= "nama".$k->id_kriteria;
                    // echo $request->$nama;
                    nilai_kriteria::create([
                                'id_user'=>Auth::user()->id,
                                'id_karyawan'=> $id,
                                'id_kriteria'=>$k->id_kriteria,
                                'tanggal_nilai'=>Carbon::now()->format('Y-m-d'),
                                'nilai_kriteria'=> $request->$nama,
                    ]);
                }
            
            }
        }

        
        // dd(Auth::user()->id);
        // dd($request->all());
        
        return redirect(route('penilaian.index',$karyawan->id_perusahaan));
    }
    public function edit($id,Request $request){
        // dd($request->tgl_bobot);
        $karyawan = karyawan::find($id);
        if($karyawan->id_pangkat==2){
            $kriteria = Kriteria::where('id_pangkat',$karyawan->id_pangkat)->get();
        }else{
            $kriteria = Kriteria::get();
        }
        
        $subkriteria = SubKriteria::get();
        $perusahaan = Perusahaan::get();
        $nilai_kriteria = nilai_kriteria::where('id_karyawan',$id)->where('id_user',Auth::user()->id)
        ->where('tanggal_nilai',$request->tgl_bobot)->get();
        $nilai_sub_kriteria=nilai_sub_kriteria::where('id_karyawan',$id)
        ->where('tanggal_nilai',$request->tgl_bobot)
        ->where('id_user',Auth::user()->id)->get();
        
        return view('pages.penilaian.edit',['karyawan'=>$karyawan,'nilai_kriteria'=>$nilai_kriteria,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'id'=>$id,'perusahaan'=>$perusahaan,'subkriteria'=>$subkriteria,'kriteria'=>$kriteria]);
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
            '*' => 'required',
        ],$messages);

        $karyawan = karyawan::find($id);
        // $kriteria = Kriteria::where('id_pangkat','2')
        // ->get();
        $subkriteria = SubKriteria::get();
        if($karyawan->id_pangkat ==2){
            $kriteria = Kriteria::where('id_pangkat','2')
            ->get();
            $subkriteria = SubKriteria::get();         
            foreach($kriteria as $k){
                $no=0;
                foreach($subkriteria as $sk){
                    if($k->id_kriteria == $sk->id_kriteria){
                        $namasub = "namasub".$sk->id_sub_kriteria;
                        echo $request->$namasub;
                        nilai_sub_kriteria::where('id_karyawan',$id)
                        ->where('id_sub_kriteria',$sk->id_sub_kriteria)->update([
                            'id_user'=>Auth::user()->id,
                            'nilai_sub_kriteria'=> $request->$namasub,
                        ]);
    
                        $no=$k->id_kriteria;
                    }
                    
                }
                echo "<br>";
                if($k->id_kriteria == $no){
                    
                }else{
                    $nama= "nama".$k->id_kriteria;
                    // echo $request->$nama;
                    nilai_kriteria::where('id_karyawan',$id)
                    ->where('id_kriteria',$k->id_kriteria)->update([
                                'id_user'=>Auth::user()->id,
                                'nilai_kriteria'=> $request->$nama,
                    ]);
                }
            
            }
            
        }else{
            $kriteria = Kriteria::get();
            $subkriteria = SubKriteria::get();         
            foreach($kriteria as $k){
                $no=0;
                foreach($subkriteria as $sk){
                    if($k->id_kriteria == $sk->id_kriteria){
                        $namasub = "namasub".$sk->id_sub_kriteria;
                        echo $request->$namasub;
                        nilai_sub_kriteria::where('id_karyawan',$id)
                        ->where('id_sub_kriteria',$sk->id_sub_kriteria)->update([
                            'id_user'=>Auth::user()->id,
                            'nilai_sub_kriteria'=> $request->$namasub,
                        ]);
                        $no=$k->id_kriteria;
                    }
                    
                }
                echo "<br>";
                if($k->id_kriteria == $no){
                    
                }else{
                    $nama= "nama".$k->id_kriteria;
                    // echo $request->$nama;
                    nilai_kriteria::where('id_karyawan',$id)
                    ->where('id_kriteria',$k->id_kriteria)->update([
                                'id_user'=>Auth::user()->id,
                                'nilai_kriteria'=> $request->$nama,
                    ]);
                }
            
            }            
        }
        
        return redirect(route('penilaian.index',$karyawan->id_perusahaan));
    }
    public function hitung($id_perusahaan,Request $request){
        // dd($id);
        
        if(Auth::user()->hasRole('manajer')  ){
            $kriteria = Kriteria::get();
            $this->bantuteam_leader($kriteria,$request->tgl,$id_perusahaan);
        }elseif(Auth::user()->hasRole('user')  ){
            // $con= new PenilaianController();
            $kriteria = Kriteria::where('id_pangkat','2')->get();
            $this->bantu($kriteria,$request->tgl,$id_perusahaan);
            
            $kriteria = Kriteria::get();
            $this->bantuteam_leader($kriteria,$request->tgl,$id_perusahaan);
        }elseif(Auth::user()->hasRole('team_leader')  ){
            $kriteria = Kriteria::where('id_pangkat','2')->get();
            $this->bantu($kriteria,$request->tgl,$id_perusahaan);
        }
        return redirect(route('penilaian.index',$id_perusahaan));
    }

    
    public function bantu($kriteria, $tgl,$id_perusahaan){
        $con= new PenilaianController();
        $subkriteria = SubKriteria::get();
        $jumlah_bobot = array();
            $kriteria_array = 0;
            $gologan = array();
            foreach($kriteria as $k){
                $subkriteria = SubKriteria::where('id_kriteria',$k->id_kriteria)->get();
                if(count($subkriteria) == 0){
                    $gologan[$kriteria_array] = $k->golongan;
                    $jumlah_bobot[$kriteria_array]= [0] ;
                    $kriteria_array++;
                }else{
                    $jumlah_bobot[$kriteria_array]=$con->hitungsubkriteria($k->id_kriteria,$id_perusahaan,$tgl,$kriteria_array);
                    $gologan[$kriteria_array] = $k->golongan;
                    $kriteria_array++;
                }
                
                // dd($jumlah_bobot);
                
                // $this->subkriteria($k->id_kriteria,$request->tgl);
            }
            // dd($jumlah_bobot[0]);
            // dd(count($jumlah_bobot[0]));
            // dd($gologan);
            if($jumlah_bobot[0]==0){
                
            }else{
                $this->hitungkriteria($tgl,$id_perusahaan,$jumlah_bobot,$gologan,$kriteria);
            }
        }



    public function hitungkriteria($tgl,$id_perusahaan,$jumlah_bobot,$gologan,$kriteria){
        
        $nilaikriteria = DB::table('karyawan as k')->join('nilai_kriteria as nk', 'k.id_karyawan' ,'=','nk.id_karyawan')
        ->join('kriteria_ahp as nsk', 'nk.id_kriteria' ,'=','nsk.id_kriteria')
        ->where('tanggal_nilai',$tgl)->where('id_perusahaan',$id_perusahaan)
        ->where('k.id_pangkat','2')
        ->where('id_user',Auth::user()->id)->get();
        // dd($nilaikriteria);
        // $gologan = array();
        $saw = array();
        $id = array();
        // for($i=0;$i<count($jumlah_bobot);$i++){
        //     // echo $i;
        //     for($j=0;$j<count($jumlah_bobot[$i]);$j++){
        //         $saw[$i][$j] = $jumlah_bobot[$i][$j];
        //     }
        // }
        // dd($gologan);
        // dd($jumlah_bobot);
        // dd($saw);
        // dd(count($saw));
        
        $i= 0;
        
        foreach($kriteria as $k){
            $id_cek=0;
            $j = 0;
            $d=array();
            foreach($nilaikriteria as $nk){
                if($k->id_kriteria == $nk->id_kriteria){
                    $saw[$i][$j] = $nk->nilai_kriteria;
                    $id[$i][$j] =  $nk->id_nilai_kriteria;
                    // $gologan[$i] = $nk->golongan;
                    $id_cek = $k->id_kriteria;
                    // echo $id[$i][$j]."_".$i;
                    $j++;
                }else{
                    $d[$i][$j] = 0;
                }
                
                // echo $saw[0][$j]." _ ".$id[$j]." __ ";
                // echo $i;
            }
            echo "<br>";
            if($id_cek == 0){
                
                for($j=0;$j<count($jumlah_bobot[$i]);$j++){
                    $saw[$i][$j] = $jumlah_bobot[$i][$j];
                    $id[$i][$j] =0  ;
                }
                // echo $id[$i];
                $i++;
                
            }else{
                // echo $id[$i];
                $i++;
                
            }
            
        }
        // dd($id);
        // dd($saw);
        // dd(count($jumlah_bobot));
        // for($i=0;$i<count($jumlah_bobot);$i++){
        //     // echo $i;
        //     for($j=0;$j<count($jumlah_bobot[$i]);$j++){
        //         $saw[$i+1][$j] = $jumlah_bobot[$i][$j];
        //     }
        // }
        // dd(go);
        // min max 
        $nilai_max_min = array();
        for($i=0; $i<count($saw); $i++){
            if($gologan[$i] == "B"){
                $nilai_max_min[$i] = max($saw[$i]);
            }else{
                $nilai_max_min[$i] = min($saw[$i]);
            }
                    
        }
        
        // dd($nilai_max_min);
        // dd($saw[1]);
        //normalisasi
        $normalisasi = array();
        for ($i=0; $i <count($saw) ; $i++) { 
                
            // echo count();
            for($j = 0; $j <count($saw[$i]); $j++){
                // echo $i;
                // echo $niali_max_min[$i];]
                if($gologan[$i] == "B"){
                    $normalisasi[$i][$j]=$saw[$i][$j]/$nilai_max_min[$i] ;
                }else{
                    $normalisasi[$i][$j]=$nilai_max_min[$i] / $saw[$i][$j];
                }
                
                
                // echo $normalisasi[$i][$j];
            }
            echo "<br>";
        }
        //ambil nilai bobot
        $bobot = array();
        $i = 0;
        foreach($kriteria as $k){
            $bobot[$i] = $k->bobot_kriteria;
            // echo $sb->bobot_sub_kriteria ;
            $i++;
        }
        $nilai_bobot = array();
        // $jumlah = array();
        echo "<br>";
        // hitung bobot
         // echo "<br>";
        //  dd($id);
        for ($i=0; $i <count($saw) ; $i++) { 
            // $jumlah[$i]=0;
            for($j=0;$j<count($saw[$i]); $j++){
               
                $nilai_bobot[$i][$j] = $normalisasi[$i][$j]*round($bobot[$i],2);
                // echo $id[$j]." _";
                if($id[$i][$j]==0){

                }else{
                    $cek = bobot_kriteria::where('id_nilai_kriteria',$id[$i][$j])
                    ->where('id_user',Auth::user()->id)
                    ->where('tanggal_bobot',$tgl)
                    ->get();
                    if(count($cek)>0){
                        bobot_kriteria::where('id_nilai_kriteria',$id[$i][$j])
                        ->where('id_user',Auth::user()->id)
                        ->where('tanggal_bobot',$tgl)->update([
                            'bobot_kriteria'=>$nilai_bobot[$i][$j],
                        ]);
                    }else{
                        // echo $id[$j]."                               " ;
                        bobot_kriteria::create([
                            'id_user'=>Auth::user()->id,
                            'id_nilai_kriteria'=>$id[$i][$j],
                            'bobot_kriteria'=>$nilai_bobot[$i][$j],
                            'tanggal_bobot'=>$tgl,
                        ]);
                    }
                }
                
                
            }
            echo "<br>";
        }
        // dd($saw);
        $jumlah_bobot = array();
        for($i=0; $i<count($saw[0]); $i++){
            // echo $i;
            
            $jumlah_bobot[$i] = 0;
            for($j=0;$j<count($saw); $j++){
                $jumlah_bobot[$i] += number_format($nilai_bobot[$j][$i] * 100,2);
            }
            
            echo $jumlah_bobot[$i]." ";
            // echo "<br>";
        }
        $karyawan = karyawan::where('id_pangkat','2')
        ->where('id_perusahaan',$id_perusahaan)->get();
        // dd(count($jumlah_bobot));
        $b = 0;
        foreach($karyawan as $k){
            $nilai_akhir =bobot_akhir::where('id_karyawan',$k->id_karyawan)
            ->where('tanggal_bobot',$tgl)->where('id_user',Auth::user()->id)->get();
            if(count($nilai_akhir)== 0){
                bobot_akhir::create([
                    'id_karyawan' => $k->id_karyawan,
                    'id_user'=>Auth::user()->id,
                    'bobot_akhir' =>$jumlah_bobot[$b],
                    'tanggal_bobot'=>$tgl,
                ]);
            }else{
                bobot_akhir::where('id_karyawan',$k->id_karyawan)
                ->where('tanggal_bobot',$tgl)->where('id_user',Auth::user()->id)->update([
                    'bobot_akhir' =>$jumlah_bobot[$b],
                ]);
            }
            $b++;
        }
    }


    public function hitungsubkriteria($id_kriteria,$id_perusahaan,$tgl,$kriteria_array){
        $subkriteria = SubKriteria::where('id_kriteria',$id_kriteria)->get();
       
        // dd($subkriteria);
        // $cekkaryawan = karyawan::where('id_karyawan', $k->id_karyawan)->get();
        // dd(count($cekkaryawan));
        $saw = array();
        $id = array();
        $gologan = array();
        $i=0;
        if(count($subkriteria)==0){

        }else{
            foreach ($subkriteria as $sk) { 
                $j=0;
                $nilai_sub_kriteria = DB::table('karyawan as k')
                ->join('nilai_sub_kriteria as nsk', 'k.id_karyawan','=','nsk.id_karyawan')
                ->join('sub_kriteria_ahp as nk', 'nk.id_sub_kriteria' ,'=','nsk.id_sub_kriteria')
                ->where('id_pangkat','2')
                ->where('id_perusahaan',$id_perusahaan)
                ->where('id_user',Auth::user()->id)
                ->where('nsk.id_sub_kriteria',$sk->id_sub_kriteria)->where('tanggal_nilai',$tgl)->get();
                // dd($nilai_sub_kriteria);
                if(count($nilai_sub_kriteria)==0){
                    return 0;
                }else{
                    foreach($nilai_sub_kriteria as $nsk){
                        $saw[$i][$j] = $nsk->nilai_sub_kriteria;
                        $id[$i][$j] = $nsk->id_nilai_sub_kriteria;
                        $gologan[$i] = $nsk->golongan;
        
                        // echo $saw[$i][$j]." ".$id[$i][$j]." ";    
                        
                        $j++;    
                    }
                    
                    // echo "<br>";
                    // echo $gologan[$i];
                    
                    $i++;
                }
                
            }
            //  dd(count($cekkaryawan));
            // dd(count($saw));
            // echo "<br>";
            // echo "<br>".count($saw[count($karyawan)-1])."<br>";
            // mencari nilai max or min 
            $niali_max_min = array();
            for ($i=0; $i <count($saw) ; $i++) { 
                // echo max($saw[0]);
                if($gologan[$i] == "B"){
                    $niali_max_min[$i] = max($saw[$i]);
                }else{
                    $niali_max_min[$i] = min($saw[$i]);
                }
                
                // echo max($saw[$i]);
                // echo  $niali_max_min[$i];
            }
            // echo "<br>";
            // dd($saw);
    
            // normalisasi
            $normalisasi = array();
            for ($i=0; $i <count($saw) ; $i++) { 
                
                // echo count();
                for($j = 0; $j <count($saw[$i]); $j++){
                    // echo $i;
                    // echo $niali_max_min[$i];]
                    if($gologan[$i] == "B"){
                        $normalisasi[$i][$j]=$saw[$i][$j]/$niali_max_min[$i] ;
                    }else{
                        $normalisasi[$i][$j]=$niali_max_min[$i] / $saw[$i][$j] ;
                    }
                    
                    
                    // echo $normalisasi[$i][$j];
                }
                // echo "<br>";
            }
            
            //ambil nilai bobot
            $subkriteria = SubKriteria::where('id_kriteria',$id_kriteria)->get();
            $bobot = array();
            $i = 0;
            foreach($subkriteria as $sb){
                $bobot[$i] = $sb->bobot_sub_kriteria;
                // echo $sb->bobot_sub_kriteria ;
                $i++;
            }
            // dd($bobot);
    
            $nilai_bobot = array();
            // $jumlah = array();
            // echo "<br>";
            // hitung bobot
             // echo "<br>";
            for ($i=0; $i <count($saw) ; $i++) { 
                // $jumlah[$i]=0;
                for($j=0;$j<count($saw[$i]); $j++){
                   
                    $nilai_bobot[$i][$j] = $normalisasi[$i][$j]*round($bobot[$i],2);
                    // // if($jumlah[$j] == null){
                    // //     // $jumlah[$j] = $nilai_bobot[$i][$j] *100;
                    // // }else{
                    // //     // $jumlah[$j] += $nilai_bobot[$i][$j] *100;    
                    // // }
                    // echo $nilai_bobot[$i][$j]."                               " ;
    
                    // // echo $jumlah[$i];
                    $cek = bobot_sub_kriteria::where('id_nilai_sub_kriteria',$id[$i][$j])->
                    where('id_user',Auth::user()->id)->
                    where('tanggal_bobot',$tgl)->get();
                    if(count($cek)>0){
                        bobot_sub_kriteria::where('id_nilai_sub_kriteria',$id[$i][$j])
                        ->where('id_user',Auth::user()->id)
                        ->where('tanggal_bobot',$tgl)->update([
                            'bobot_kriteria'=>$nilai_bobot[$i][$j],
                        ]);
                    }else{
                        bobot_sub_kriteria::create([
                            'id_user'=>Auth::user()->id,
                            'id_nilai_sub_kriteria'=>$id[$i][$j],
                            'bobot_kriteria'=>$nilai_bobot[$i][$j],
                            'tanggal_bobot'=>$tgl,
                        ]);
                    }
                    
                }
                // echo "<br>";
            }
            $jumlah_bobot = array();
            for($i=0; $i<count($saw[0]); $i++){
                // echo $i;
                $jumlah_bobot[$i] = 0;
                for($j=0;$j<count($saw); $j++){
                    $jumlah_bobot[$i] += number_format($nilai_bobot[$j][$i] * 100,2);
                        
                    
                }
                // echo $jumlah_bobot[$i]." ";
                // echo "<br>";
            }
            return $jumlah_bobot;
    
        }
           
    }



    public function bantuteam_leader($kriteria,$tgl){
        $con= new PenilaianController();
        $subkriteria = SubKriteria::get();
        $jumlah_bobot = array();
            $kriteria_array = 0;
            $gologan = array();
            foreach($kriteria as $k){
                $subkriteria = SubKriteria::where('id_kriteria',$k->id_kriteria)->get();
                if(count($subkriteria) == 0){
                    $gologan[$kriteria_array] = $k->golongan;
                    $jumlah_bobot[$kriteria_array]= [0] ;
                    $kriteria_array++;
                }else{
                    $jumlah_bobot[$kriteria_array]=$con->hitungsubkriteria_team_leader($k->id_kriteria,$tgl);
                    $gologan[$kriteria_array] = $k->golongan;
                    $kriteria_array++;
                }
                
                // dd($jumlah_bobot);
                
                // $this->subkriteria($k->id_kriteria,$request->tgl);
            }
            // dd($jumlah_bobot);
            // dd(count($jumlah_bobot[0]));
            // dd($gologan);
            if($jumlah_bobot[0]==0){
                
            }else{
                $this->hitungkriteria_team_leader($jumlah_bobot,$gologan,$kriteria,$tgl);
            }
    }



    public function hitungkriteria_team_leader($jumlah_bobot,$gologan,$kriteria,$tgl){
        $nilaikriteria = DB::table('karyawan as k')->join('nilai_kriteria as nk', 'k.id_karyawan' ,'=','nk.id_karyawan')
        ->join('kriteria_ahp as nsk', 'nk.id_kriteria' ,'=','nsk.id_kriteria')
        ->where('k.id_pangkat','1')
        ->where('id_user',Auth::user()->id)->get();
        // dd($nilaikriteria);
        // $gologan = array();
        // dd($jumlah_bobot);
        $saw = array();
        $id = array();
        $i= 0;
        // dd(count($jumlah_bobot));
        foreach($kriteria as $k){
            $id_cek=0;
            $j = 0;
            foreach($nilaikriteria as $nk){
                if($k->id_kriteria == $nk->id_kriteria){
                    $saw[$i][$j] = $nk->nilai_kriteria;
                    $id[$i][$j]  =  $nk->id_nilai_kriteria;
                    // $gologan[$i] = $nk->golongan;
                    $id_cek = $k->id_kriteria;
                    // echo $i;
                    $j++;
                }
                
                // echo $saw[0][$j]." _ ".$id[$j]." __ ";
                // echo $i;
            }
            if($id_cek == 0){
                
                for($j=0;$j<count($jumlah_bobot[$i]);$j++){
                    $saw[$i][$j] = $jumlah_bobot[$i][$j];
                    $id[$i][$j] =0  ;
                }
                $i++;
            }else{
                $i++;
            }
        }
        
        // dd(go);
        
        // min max 
        $nilai_max_min = array();
        for($i=0; $i<count($saw); $i++){
            if($gologan[$i] == "B"){
                $nilai_max_min[$i] = max($saw[$i]);
            }else{
                $nilai_max_min[$i] = min($saw[$i]);
            }
                    
        }
        //normalisasi
        $normalisasi = array();
        for ($i=0; $i <count($saw) ; $i++) { 
                
            // echo count();
            for($j = 0; $j <count($saw[$i]); $j++){
                // echo $i;
                // echo $niali_max_min[$i];]
                if($gologan[$i] == "B"){
                    $normalisasi[$i][$j]=$saw[$i][$j]/$nilai_max_min[$i] ;
                }else{
                    $normalisasi[$i][$j]=$nilai_max_min[$i] / $saw[$i][$j] ;
                }
                
                
                echo $normalisasi[$i][$j];
            }
            echo "<br>";
        }
        // dd($saw);
        //ambil nilai bobot
        $bobot = array();
        $i = 0;
        foreach($kriteria as $k){
            $bobot[$i] = $k->bobot_kriteria;
            echo $k->bobot_kriteria ;
            $i++;
        }
        // dd($saw);
        $nilai_bobot = array();
        // $jumlah = array();
        echo "<br>";
        // hitung bobot
         // echo "<br>";
        for ($i=0; $i <count($saw) ; $i++) { 
            // $jumlah[$i]=0;
            for($j=0;$j<count($saw[$i]); $j++){
            //    dd(round($bobot[$i]));
                $nilai_bobot[$i][$j] = $normalisasi[$i][$j]*round($bobot[$i],2);
                
                if($id[$i][$j]==0){

                }else{
                    $cek = bobot_kriteria::where('id_nilai_kriteria',$id[$i][$j])
                    ->where('id_user',Auth::user()->id)
                    ->where('tanggal_bobot',$tgl)
                    ->get();
                    if(count($cek)>0){
                        bobot_kriteria::where('id_nilai_kriteria',$id[$i][$j])
                        ->where('id_user',Auth::user()->id)
                        ->where('tanggal_bobot',$tgl)->update([
                            'bobot_kriteria'=>$nilai_bobot[$i][$j],
                        ]);
                    }else{
                        // echo $id[$j]."                               " ;
                        bobot_kriteria::create([
                            'id_user'=>Auth::user()->id,
                            'id_nilai_kriteria'=>$id[$i][$j],
                            'bobot_kriteria'=>$nilai_bobot[$i][$j],
                            'tanggal_bobot'=>$tgl,
                        ]);
                    }
                }
                // echo $nilai_bobot[$i];
               
                
            }
            echo "<br>";

        }
        // dd($nilai_bobot);
        $jumlah_bobot = array();
        for($i=0; $i<count($saw[0]); $i++){
            // echo $i;
            
            $jumlah_bobot[$i] = 0;
            for($j=0;$j<count($saw); $j++){
                $jumlah_bobot[$i] += number_format($nilai_bobot[$j][$i] * 100,2);

            }
            
            echo $jumlah_bobot[$i]." ";
            // echo "<br>";
        }
        $karyawan = karyawan::where('id_pangkat','1')->get();
        // dd(count($jumlah_bobot));
        $b = 0;
        foreach($karyawan as $k){
            $nilai_akhir =bobot_akhir::where('id_karyawan',$k->id_karyawan)
            ->where('tanggal_bobot',$tgl)->where('id_user',Auth::user()->id)->get();
            if(count($nilai_akhir)== 0){

                bobot_akhir::create([
                    'id_karyawan' => $k->id_karyawan,
                    'id_user'=>Auth::user()->id,
                    'bobot_akhir' =>$jumlah_bobot[$b],
                    'tanggal_bobot'=>$tgl,
                ]);
            }else{
                bobot_akhir::where('id_karyawan',$k->id_karyawan)
                ->where('tanggal_bobot',$tgl)->where('id_user',Auth::user()->id)->update([
                    'bobot_akhir' =>$jumlah_bobot[$b],
                ]);
            }
            $b++;
        }
    }


    public function hitungsubkriteria_team_leader($id_kriteria,$tgl){
        $subkriteria = SubKriteria::where('id_kriteria',$id_kriteria)->get();
       
        // dd($subkriteria);
        // $cekkaryawan = karyawan::where('id_karyawan', $k->id_karyawan)->get();
        // dd(count($cekkaryawan));
        $saw = array();
        $id = array();
        $gologan = array();
        $i=0;
        if(count($subkriteria)==0){

        }else{
            foreach ($subkriteria as $sk) { 
                $j=0;
                $nilai_sub_kriteria = DB::table('karyawan as k')
                ->join('nilai_sub_kriteria as nsk', 'k.id_karyawan','=','nsk.id_karyawan')
                ->join('sub_kriteria_ahp as nk', 'nk.id_sub_kriteria' ,'=','nsk.id_sub_kriteria')
                ->where('id_pangkat','1')
                ->where('id_user',Auth::user()->id)
                ->where('nsk.id_sub_kriteria',$sk->id_sub_kriteria)->where('tanggal_nilai',$tgl)->get();
                // dd($nilai_sub_kriteria);
                if(count($nilai_sub_kriteria)==0){
                    return 0;
                }else{
                    foreach($nilai_sub_kriteria as $nsk){
                        $saw[$i][$j] = $nsk->nilai_sub_kriteria;
                        $id[$i][$j] = $nsk->id_nilai_sub_kriteria;
                        $gologan[$i] = $nsk->golongan;
        
                        // echo $saw[$i][$j]." ".$id[$i][$j]." ";    
                        
                        $j++;    
                    }
                    
                    // echo "<br>";
                    // echo $gologan[$i];
                    
                    $i++;
                }
                
            }
            //  dd(count($cekkaryawan));
            // dd(count($saw));
            // echo "<br>";
            // echo "<br>".count($saw[count($karyawan)-1])."<br>";
            // mencari nilai max or min 
            $niali_max_min = array();
            for ($i=0; $i <count($saw) ; $i++) { 
                // echo max($saw[0]);
                if($gologan[$i] == "B"){
                    $niali_max_min[$i] = max($saw[$i]);
                }else{
                    $niali_max_min[$i] = min($saw[$i]);
                }
                
                // echo max($saw[$i]);
                // echo  $niali_max_min[$i];
            }
            // echo "<br>";
            // dd($saw);
    
            // normalisasi
            $normalisasi = array();
            for ($i=0; $i <count($saw) ; $i++) { 
                
                // echo count();
                for($j = 0; $j <count($saw[$i]); $j++){
                    // echo $i;
                    // echo $niali_max_min[$i];]
                    if($gologan[$i] == "B"){
                        $normalisasi[$i][$j]=$saw[$i][$j]/$niali_max_min[$i] ;
                    }else{
                        $normalisasi[$i][$j]=$niali_max_min[$i] / $saw[$i][$j] ;
                    }
                    
                    
                    // echo $normalisasi[$i][$j];
                }
                // echo "<br>";
            }
            
            //ambil nilai bobot
            $subkriteria = SubKriteria::where('id_kriteria',$id_kriteria)->get();
            $bobot = array();
            $i = 0;
            foreach($subkriteria as $sb){
                $bobot[$i] = $sb->bobot_sub_kriteria;
                // echo $sb->bobot_sub_kriteria ;
                $i++;
            }
            // dd($bobot);
    
            $nilai_bobot = array();
            // $jumlah = array();
            // echo "<br>";
            // hitung bobot
             // echo "<br>";
            for ($i=0; $i <count($saw) ; $i++) { 
                // $jumlah[$i]=0;
                for($j=0;$j<count($saw[$i]); $j++){
                   
                    $nilai_bobot[$i][$j] = $normalisasi[$i][$j]*round($bobot[$i],2);
                    // // if($jumlah[$j] == null){
                    // //     // $jumlah[$j] = $nilai_bobot[$i][$j] *100;
                    // // }else{
                    // //     // $jumlah[$j] += $nilai_bobot[$i][$j] *100;    
                    // // }
                    // echo $nilai_bobot[$i][$j]."                               " ;
    
                    // // echo $jumlah[$i];
                    $cek = bobot_sub_kriteria::where('id_nilai_sub_kriteria',$id[$i][$j])
                    ->where('id_user',Auth::user()->id)
                    ->where('tanggal_bobot',$tgl)->get();
                    if(count($cek)>0){
                        bobot_sub_kriteria::where('id_nilai_sub_kriteria',$id[$i][$j])
                        ->where('id_user',Auth::user()->id)
                        ->where('tanggal_bobot',$tgl)->update([
                            'bobot_kriteria'=>$nilai_bobot[$i][$j],
                        ]);
                    }else{
                        bobot_sub_kriteria::create([
                            'id_user'=>Auth::user()->id,
                            'id_nilai_sub_kriteria'=>$id[$i][$j],
                            'bobot_kriteria'=>$nilai_bobot[$i][$j],
                            'tanggal_bobot'=>$tgl,
                        ]);
                    }
                    
                }
                // echo "<br>";
            }
            $jumlah_bobot = array();
            for($i=0; $i<count($saw[0]); $i++){
                // echo $i;
                $jumlah_bobot[$i] = 0;
                for($j=0;$j<count($saw); $j++){
                    $jumlah_bobot[$i] += number_format($nilai_bobot[$j][$i] * 100,2);
                        
                    
                }
                // echo $jumlah_bobot[$i]." ";
                // echo "<br>";
            }
            // dd($jumlah_bobot);
            return $jumlah_bobot;
    
        }
    }
}
