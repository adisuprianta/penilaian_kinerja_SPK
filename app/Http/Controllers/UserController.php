<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\Role;
use App\Models\role_user;
use App\Models\role_user_perusahaan;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(){
        $user =DB::table('users as u')->select('u.*','r.display_name','pp.nama_perusahaan' )
        ->join('role_user as ru', 'ru.user_id' ,'=','u.id')
        ->join('roles as r','r.id','=','ru.role_id')
        ->leftJoin('role_user_perusahaan as rup','rup.user_id','=','u.id')
        ->leftJoin('perusahaan_partner as pp','pp.id_perusahaan','=','rup.id_perusahaan')
        ->get();

        // dd($user);
        return view("pages.user.index",['user' =>$user]);
    }
    public function create(){
        $perusahaan = Perusahaan::get();
        return view('pages.user.create',['perusahaan'=>$perusahaan]);
    }
    public function edit($id){
        $user =DB::table('users as u')->select('u.*','r.id','rup.id_perusahaan' )
        ->join('role_user as ru', 'ru.user_id' ,'=','u.id')
        ->join('roles as r','r.id','=','ru.role_id')
        ->leftJoin('role_user_perusahaan as rup','rup.user_id','=','u.id')
        ->where('u.id',$id)
        ->get();
        $role = Role::get();
        $nama= User::find($id);
        $perusahaan = Perusahaan::get();
        return view('pages.user.edit',['role'=>$role,'nama'=>$nama,'perusahaan'=>$perusahaan,'user'=>$user]);
    }
    public function update($id,Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            // 'password' => ['required'],
        ]);

        $user = User::where('id',$id)->update([
            'name' => $request->name,
            'email' => $request->email,
            // 'password' => Hash::make($request->password),
        ]);
        // dd($request->perusahaan);
        DB::table('role_user')->where('user_id',$id)->update([
            'role_id'=>$request->role,
        ]);
        $idrole=role_user_perusahaan::where('user_id',$id)->get();
        // dd($user->id);
        // dd(count($idrole));
        // dd($request->perusahaan);
        // $user->attachRole($request->role);
        if(count($idrole) == 0 AND $request->perusahaan !="null"){
            // dd(count($idrole));
            role_user_perusahaan::create([
                'id_perusahaan'=>$request->perusahaan,
                'user_id'=>$id,
            ]);
        }elseif($request->perusahaan !="null"){
            // dd($request->perusahaan);
            role_user_perusahaan::where('user_id',$id)->update([
                'id_perusahaan'=>$request->perusahaan,
            ]);
        }
        else{
            // dd($request->perusahaan);   
            role_user_perusahaan::where('user_id',$id)->delete();
        }
        $user = User::find($id);
        Alert::success('Sukses', "User dengan nama {$user->name} berhasil diupdate");
        return redirect(route('user.index'));
    }
    public function store(Request $request){
        // dd($request->perusahaan);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // dd($user->id);
        $user->attachRole($request->role);
        if($request->perusaahaan !="null"){
            role_user_perusahaan::create([
                'id_perusahaan'=>$request->perusahaan,
                'user_id'=>$user->id,
            ]);
        }
        
        Alert::success('Sukses', "User dengan nama {$user->name} berhasil diinputkan");
        return redirect("/user");
    }
    public function destroy($id){
        $user=User::find($id);
        $user->delete();

        Alert::success('Sukses', "User dengan nama {$user->name} berhasil dihapus");
        return redirect()->back();
    }
}
