<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    protected $table = 'sub_kriteria_ahp';
    protected $primaryKey= "id_sub_kriteria";
    public $guarded = [];
}
