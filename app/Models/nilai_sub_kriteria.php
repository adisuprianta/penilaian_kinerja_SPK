<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilai_sub_kriteria extends Model
{
    protected $table = 'nilai_sub_kriteria';
    protected $primaryKey= "id_nilai_sub_kriteria";
    public $guarded = [];
    public function bobot_sub_kriteria(){
        return $this->hasOne('App\bobot_sub_kriteria');;
    }
}
