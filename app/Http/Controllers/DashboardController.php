<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $perusahaan = Perusahaan::get();
        return view('pages.dashboard',['perusahaan'=>$perusahaan]);

    }
}
