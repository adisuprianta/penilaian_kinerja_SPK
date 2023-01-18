<?php

namespace App\Http\Controllers;

use App\Models\bobot_akhir;
use App\Models\bobot_kriteria;
use App\Models\bobot_sub_kriteria;
use App\Models\karyawan;
use App\Models\Kriteria;
use App\Models\nilai_kriteria;
use App\Models\nilai_sub_kriteria;
use App\Models\role_user_perusahaan;
use App\Models\SubKriteria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenilaianManajerController extends Controller
{
    public function index(){
        $karyawan = DB::table('karyawan as k')
        ->select('pk.nama_pangkat','pp.nama_perusahaan','k.id_karyawan','k.nama_karyawan','k.jenis_kelamin')
        ->join('kontrak_karyawan as kk','k.id_karyawan','=','kk.id_karyawan')->
        join('pangkat_karyawan as pk','k.id_pangkat','=','pk.id_pangkat_karyawan')->
        join('perusahaan_partner as pp', 'k.id_perusahaan','=','pp.id_perusahaan')
        ->where('kk.status','A')
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
        return view('pages.penilaian_manajer.index',['nilai_kriteria'=>$nilai_kriteria,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'karyawan'=>$karyawan,'tanggal'=>$tanggal]);
    }
    public function date_cari(Request $request){
        $messages= [
            'required' => 'data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
            'date'=> ':Nilai inputan harus diisi dengan tanggal',
            
        ];
        $request->validate([
            "date" => ['required','date'],
        ],$messages);
        $karyawan = DB::table('karyawan as k')
        ->select('pk.nama_pangkat','pp.nama_perusahaan','k.id_karyawan','k.nama_karyawan','k.jenis_kelamin')
        ->join('kontrak_karyawan as kk','k.id_karyawan','=','kk.id_karyawan')->
        join('pangkat_karyawan as pk','k.id_pangkat','=','pk.id_pangkat_karyawan')->
        join('perusahaan_partner as pp', 'k.id_perusahaan','=','pp.id_perusahaan')
        ->where('kk.status','A')
        ->where('k.id_pangkat','1')
        ->get();
        // ->groupBy('k.id_pangkat','k.id_karyawan','k.id_perusahaan','k.nama_karyawan','k.email','k.no_hp','k.jenis_kelamin','k.alamat','k.tanggal_lahir','k.created_at','k.updated_at')
        // ->leftJoin('nilai_sub_kriteria as ns','k.id_karyawan','=','ns.id_karyawan')
        $tanggal = $request->date;
        // dd($tanggal);
        $nilai_kriteria = nilai_kriteria::where('id_user',Auth::user()->id)
        ->where('tanggal_nilai',$request->date)
        ->get();
        $nilai_sub_kriteria=nilai_sub_kriteria::where('id_user',Auth::user()->id)
        ->where('tanggal_nilai',$request->date)->get();
        // dd($karyawan);
        // dd($nilai_kriteria);
        // $perusahaan = Perusahaan::get();
        return view('pages.penilaian_manajer.index',['nilai_kriteria'=>$nilai_kriteria,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'karyawan'=>$karyawan,'tanggal'=>$tanggal]);
        // dd($request->date);
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
        return view('pages.penilaian_manajer.create',['karyawan'=>$karyawan,'id'=>$id,'subkriteria'=>$subkriteria,'kriteria'=>$kriteria]);
    }
    public function store(Request $request,$id){
        $messages= [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
            'date'=> ':Nilai inputan harus diisi dengan tanggal',
            
        ];
        $karyawan = karyawan::find($id);
        // $cek = array();
        if($karyawan->id_pangkat ==2){
            $kriteria = Kriteria::where('id_pangkat','2')
            ->get();
            $subkriteria = SubKriteria::get(); 
            $i = 0;        
            foreach($kriteria as $k){
                $no=0;
                // $cek[$i] =0; 
                foreach($subkriteria as $sk){
                    if($k->id_kriteria == $sk->id_kriteria){
                        $namasub = "namasub".$sk->id_sub_kriteria;
                        // $cek[$i]=$namasub;
                        $no=$k->id_kriteria;
                        $request->validate([
                            $namasub => 'required',
                        ],$messages);
                    }
                    
                }
                echo "<br>";
                if($k->id_kriteria == $no){
                    
                }else{
                    $nama= "nama".$k->id_kriteria;
                    $request->validate([
                        $nama => 'required',
                    ],$messages);
                    // echo $request->$nama;
                    // $cek[$i]=$nama;
                }
                $i++;
            
            }
        }else{
            $kriteria = Kriteria::get();
            $subkriteria = SubKriteria::get(); 
            $i = 0;        
            foreach($kriteria as $k){
                $no=0;
                // $cek[$i] =0; 
                foreach($subkriteria as $sk){
                    if($k->id_kriteria == $sk->id_kriteria){
                        $namasub = "namasub".$sk->id_sub_kriteria;
                        // $cek[$i]=$namasub;
                        $no=$k->id_kriteria;
                        $request->validate([
                            $namasub => 'required',
                        ],$messages);
                    }
                    
                }
                echo "<br>";
                if($k->id_kriteria == $no){
                    
                }else{
                    $nama= "nama".$k->id_kriteria;
                    $request->validate([
                        $nama => 'required',
                    ],$messages);
                    // echo $request->$nama;
                    // $cek[$i]=$nama;
                }
                $i++;
            
            }
        }
        // dd($request->all());
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
        
        return redirect(route('penilaian_manajer.index'));
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
        $nilai_kriteria = nilai_kriteria::where('id_karyawan',$id)->where('id_user',Auth::user()->id)
        ->where('tanggal_nilai',$request->tgl_bobot)->get();
        $nilai_sub_kriteria=nilai_sub_kriteria::where('id_karyawan',$id)
        ->where('tanggal_nilai',$request->tgl_bobot)
        ->where('id_user',Auth::user()->id)->get();
        
        return view('pages.penilaian_manajer.edit',['karyawan'=>$karyawan,'nilai_kriteria'=>$nilai_kriteria,'nilai_sub_kriteria'=>$nilai_sub_kriteria,'id'=>$id,'subkriteria'=>$subkriteria,'kriteria'=>$kriteria]);
    }
    public function update($id,Request $request){
        
        $messages= [
            'required' => ':semua data wajib diisi!!!',
            'between' => 'Nilai harus di isi dari :min - :max bukan :input!!!',
            'min' => ':nilai harus diisi minimal :min karakter!!!',
            'max' => ':nilai harus diisi maksimal :max karakter!!!',
            'date'=> ':Nilai inputan harus diisi dengan tanggal',
            
        ];
        $karyawan = karyawan::find($id);
        // $cek = array();
        if($karyawan->id_pangkat ==2){
            $kriteria = Kriteria::where('id_pangkat','2')
            ->get();
            $subkriteria = SubKriteria::get(); 
            $i = 0;        
            foreach($kriteria as $k){
                $no=0;
                // $cek[$i] =0; 
                foreach($subkriteria as $sk){
                    if($k->id_kriteria == $sk->id_kriteria){
                        $namasub = "namasub".$sk->id_sub_kriteria;
                        // $cek[$i]=$namasub;
                        $no=$k->id_kriteria;
                        $request->validate([
                            $namasub => 'required',
                        ],$messages);
                    }
                    
                }
                echo "<br>";
                if($k->id_kriteria == $no){
                    
                }else{
                    $nama= "nama".$k->id_kriteria;
                    $request->validate([
                        $nama => 'required',
                    ],$messages);
                    // echo $request->$nama;
                    // $cek[$i]=$nama;
                }
                $i++;
            
            }
        }else{
            $kriteria = Kriteria::get();
            $subkriteria = SubKriteria::get(); 
            $i = 0;        
            foreach($kriteria as $k){
                $no=0;
                // $cek[$i] =0; 
                foreach($subkriteria as $sk){
                    if($k->id_kriteria == $sk->id_kriteria){
                        $namasub = "namasub".$sk->id_sub_kriteria;
                        // $cek[$i]=$namasub;
                        $no=$k->id_kriteria;
                        $request->validate([
                            $namasub => 'required',
                        ],$messages);
                    }
                    
                }
                echo "<br>";
                if($k->id_kriteria == $no){
                    
                }else{
                    $nama= "nama".$k->id_kriteria;
                    $request->validate([
                        $nama => 'required',
                    ],$messages);
                    // echo $request->$nama;
                    // $cek[$i]=$nama;
                }
                $i++;
            
            }
        }
        $request->validate([
            '*' => 'required',
        ],$messages);

        $karyawan = karyawan::find($id);
        // $kriteria = Kriteria::where('id_pangkat','2')
        // ->get();
        $subkriteria = SubKriteria::get();
        // dd($subkriteria);
        if($karyawan->id_pangkat ==2){
            // dd($subkriteria);
            $kriteria = Kriteria::where('id_pangkat','2')
            ->get();
            $subkriteria = SubKriteria::get();         
            foreach($kriteria as $k){
                $no=0;
                foreach($subkriteria as $sk){
                    if($k->id_kriteria == $sk->id_kriteria){
                        $namasub = "namasub".$sk->id_sub_kriteria;
                        echo $request->$namasub;
                        nilai_sub_kriteria::where('id_karyawan',$id)->where('id_user',Auth::user()->id)
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
                    nilai_kriteria::where('id_karyawan',$id)->where('id_user',Auth::user()->id)
                    ->where('id_kriteria',$k->id_kriteria)->update([
                                'id_user'=>Auth::user()->id,
                                'nilai_kriteria'=> $request->$nama,
                    ]);
                }
            
            }
            
        }else{
            
            $kriteria = Kriteria::get();
            $subkriteria = SubKriteria::get();         
            // dd($kriteria);
            foreach($kriteria as $k){
                $no=0;
                foreach($subkriteria as $sk){
                    if($k->id_kriteria == $sk->id_kriteria){
                        $namasub = "namasub".$sk->id_sub_kriteria;
                        echo $request->$namasub;
                        nilai_sub_kriteria::where('id_karyawan',$id)->where('id_user',Auth::user()->id)
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
                    nilai_kriteria::where('id_karyawan',$id)->where('id_user',Auth::user()->id)
                    ->where('id_kriteria',$k->id_kriteria)->update([
                                'id_user'=>Auth::user()->id,
                                'nilai_kriteria'=> $request->$nama,
                    ]);
                }
            
            }            
        }
        
        return redirect(route('penilaian_manajer.index'));
    }
    public function hitung(Request $request){
        // dd($id);
        // dd("a");

        $kriteria = Kriteria::get();
        $this->bantuteam_leader($kriteria,$request->tgl);
        return redirect(route('penilaian_manajer.index'));
    }



    public function bantuteam_leader($kriteria,$tgl){
        // $con= new PenilaianController();
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
                    $jumlah_bobot[$kriteria_array]=$this->hitungsubkriteria_team_leader($k->id_kriteria,$tgl);
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
        ->join('users as u', 'u.id','=','nk.id_kriteria')
        ->where('k.id_pangkat','1')
        ->where('id_user',Auth::user()->id)
        ->get();
        $user = array();
        $id_karyawan = array();
        $saw = array();
        $id = array();
        $i= 0;
        // dd($nilaikriteria);
        foreach($kriteria as $k){
            $id_cek=0;
            $j = 0;
            foreach($nilaikriteria as $nk){
                if($k->id_kriteria == $nk->id_kriteria){
                    $saw[$i][$j] = $nk->nilai_kriteria;
                    $id[$i][$j]  =  $nk->id_nilai_kriteria;
                    // $gologan[$i] = $nk->golongan;
                    $user[$i][$j] = $nk->id_user;
                    $id_cek = $k->id_kriteria;
                    echo $j;
                    $j++;
                }
                
                // echo $saw[0][$j]." _ ".$id[$j]." __ ";
                // echo $i;
            }
            if($id_cek == 0){
                
                for($j=0;$j<count($jumlah_bobot[$i]);$j++){
                    $saw[$i][$j] = $jumlah_bobot[$i][$j];
                    $user[$i][$j] = 0;
                    $id[$i][$j] =0  ;
                }
                $i++;
            }else{
                $i++;
            }
        }
        
        // dd($user);
        
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
                
                
                // echo $normalisasi[$i][$j];
            }
            echo "<br>";
        }
        // dd($saw);
        //ambil nilai bobot
        $KriteriaController = new KriteriaController();
        $bobot = $bobot = $KriteriaController->HitungBobotKriteria($kriteria);;
        
        // dd($user);
        // dd($saw);
        $nilai_bobot = array();
        
        // hitung bobot
        for ($i=0; $i <count($saw) ; $i++) { 
            // $jumlah[$i]=0;
            for($j=0;$j<count($saw[$i]); $j++){
            //    dd(round($bobot[$i]));
                $nilai_bobot[$i][$j] = $normalisasi[$i][$j]*round($bobot[$i],2);
                
                if($id[$i][$j]==0){

                }else{
                    $cek = bobot_kriteria::where('id_nilai_kriteria',$id[$i][$j] )
                    ->where('id_user',$user[$i][$j] )
                    ->where('tanggal_bobot',$tgl)
                    ->get();
                    // dd();
                    if(count($cek)>0){
                        echo count($cek);
                        bobot_kriteria::where('id_nilai_kriteria',$id[$i][$j])
                        ->where('id_user',$user[$i][$j] )
                        ->where('tanggal_bobot',$tgl)->update([
                            'bobot_kriteria'=>$nilai_bobot[$i][$j],
                        ]);
                    }elseif($user[$i][$j]!=0 AND $id[$i][$j]!=0 ){
                        echo count($cek);
                        // echo $id[$j]."                               " ;
                        bobot_kriteria::create([
                            'id_user'=>$user[$i][$j],
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
        // dd($id);
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
        // dd($nilaikriteria);
        // dd($karyawan);
        // $id_karyawan[$j]=$nk->id_karyawan;
        // dd(count($jumlah_bobot));
        $id_user = array();
        $b = 0;
        foreach($karyawan as $k){
            echo $k->id_karyawan;
            foreach($nilaikriteria as $nk){
                if($k->id_karyawan == $nk->id_karyawan){
                    $id_karyawan[$b]=$nk->id_karyawan;
                    $id_user[$b] = $nk->id_user;
                    $b++;    
                }
            }
            
            
        }
        // dd($nilaikriteria);
        for ($i=0; $i <count($id_karyawan) ; $i++) { 
            // dd($id_karyawan[$i]);
            $nilai_akhir =bobot_akhir::where('id_karyawan',$id_karyawan[$i])
            ->where('tanggal_bobot',$tgl)->where('id_user',$id_user[$i])->get();
                // dd($nilai_akhir);
                if(count($nilai_akhir)== 0){
                    bobot_akhir::create([
                        'id_karyawan' => $id_karyawan[$i],
                        'id_user'=>$id_user[$i],
                        'bobot_akhir' =>$jumlah_bobot[$i],
                        'tanggal_bobot'=>$tgl,
                    ]);
                }else{
                    // dd($jumlah_bobot[$i]);
                    bobot_akhir::where('id_karyawan',$id_karyawan[$i])
                    ->where('tanggal_bobot',$tgl)->where('id_user',$id_user[$i])->update([
                        'bobot_akhir' =>$jumlah_bobot[$i],
                    ]);
                }
        }
        
        // dd($nilaikriteria);
        // $gologan = array();
        // dd($jumlah_bobot);
        
    }


    public function hitungsubkriteria_team_leader($id_kriteria,$tgl){
        $subkriteria = SubKriteria::where('id_kriteria',$id_kriteria)->get();
       
        // dd($subkriteria);
        // $cekkaryawan = karyawan::where('id_karyawan', $k->id_karyawan)->get();
        // dd(count($cekkaryawan));
        $user=array();
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
                        $user[$i][$j] = $nsk->id_user;
                        // echo $saw[$i][$j]." ".$id[$i][$j]." ";    
                        
                        $j++;    
                    }
                    
                    // echo "<br>";
                    // echo $gologan[$i];
                    
                    $i++;
                }
                
            }
            //  dd(count($cekkaryawan));
            // dd($user);

            // mencari nilai max or min 
            $niali_max_min = array();
            for ($i=0; $i <count($saw) ; $i++) { 
                // echo max($saw[0]);
                if($gologan[$i] == "B"){
                    $niali_max_min[$i] = max($saw[$i]);
                }else{
                    $niali_max_min[$i] = min($saw[$i]);
                }
            }
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
            
            // hitung bobot
            
            for ($i=0; $i <count($saw) ; $i++) { 
                // $jumlah[$i]=0;
                for($j=0;$j<count($saw[$i]); $j++){
                   
                    $nilai_bobot[$i][$j] = $normalisasi[$i][$j]*round($bobot[$i],2);
            
                    // // echo $jumlah[$i];
                    $cek = bobot_sub_kriteria::where('id_nilai_sub_kriteria',$id[$i][$j])
                    ->where('id_user',$user[$i][$j])
                    ->where('tanggal_bobot',$tgl)->get();
                    if(count($cek)>0){
                        bobot_sub_kriteria::where('id_nilai_sub_kriteria',$id[$i][$j])
                        ->where('id_user',$user[$i][$j])
                        ->where('tanggal_bobot',$tgl)->update([
                            'bobot_kriteria'=>$nilai_bobot[$i][$j],
                        ]);
                    }else{
                        bobot_sub_kriteria::create([
                            'id_user'=> $user[$i][$j],
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
            // dd($saw);
            // dd($nilai_bobot);
            // dd($jumlah_bobot);
            return $jumlah_bobot;
    
        }
    }
}
