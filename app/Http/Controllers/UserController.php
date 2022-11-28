<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
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
        $user =DB::table('users as u')-> select('u.*','r.display_name' )->
        join('role_user as ru', 'ru.user_id' ,'=','u.id')->join('roles as r','r.id','=','ru.role_id')->get();

        
        return view("pages.user.index",['user' =>$user]);
    }
    public function create(){
        
        return view('pages.user.create');
    }
    public function store(Request $request){
        
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
        $user->attachRole($request->role);
        

        return redirect("/user");
    }
    public function destroy($id){
        $user=User::find($id);
        $user->delete();

        Alert::success('Sukses', "User dengan nama {$user->name} berhasil dihapus");
        return redirect()->back();
    }
}
