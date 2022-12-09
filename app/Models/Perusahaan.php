<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = 'Perusahaan_partner';
    protected $primaryKey= "id_perusahaan";
    public $guarded = [];
}
