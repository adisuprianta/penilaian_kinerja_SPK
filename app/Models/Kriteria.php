<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria_ahp';
    protected $primaryKey= "id_kriteria";
    public $guarded = [];

}
