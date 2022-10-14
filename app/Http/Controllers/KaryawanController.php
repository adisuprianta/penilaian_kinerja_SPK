<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(){
        return view('pages.karyawan.index');
    }
    public function create(){
        return view('pages.karyawan.create');
    }
}
