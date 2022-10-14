<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        if(Auth::user()->hasRole('manajer') ){
            return view('pages.dashboard');
        }else if(Auth::user()->hasRole('team_leader')){
            return view('pages.dashboard');
        }else if(Auth::user()->hasRole('user')){
            return view('pages.dashboard');
        }

    }
}
