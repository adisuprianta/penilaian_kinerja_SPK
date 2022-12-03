<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pangkat_karyawan extends Model
{
    protected $table = 'pangkat_karyawan';
    protected $primaryKey= "id_pangkat_karyawan";
    public $guarded = [];
}
