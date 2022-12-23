<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilai_kriteria extends Model
{
    protected $table = 'nilai_kriteria';
    protected $primaryKey= "id_nilai_kriteria";
    public $guarded = [];
    public function bobot_kriteria(){
        return $this->hasOne('App\bobot_kriteria');;
    }
}