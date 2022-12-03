<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan_karyawan extends Model
{
    protected $table = 'pekerjaan_karyawan';
    protected $primaryKey= "id_karyawan";
    public $guarded = [];
}
