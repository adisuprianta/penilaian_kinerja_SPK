<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak_kerja extends Model
{
    protected $table = 'kontrak_karyawan';
    protected $primaryKey= "id_kontrak";
    public $guarded = [];
}
