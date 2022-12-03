<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyelesaian_pekerjaan extends Model
{
    protected $table = 'penyelesaian_pekerjaan';
    protected $primaryKey= "id_penyelesaian_pekerjaan";
    public $guarded = [];
}
