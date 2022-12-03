<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    public function index(){
        $pekerjaan = Pekerjaan::get();
        return view('pages.pekerjaan.index',['pekerjaan'=>$pekerjaan]);
    }
}
