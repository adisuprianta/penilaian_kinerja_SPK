<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bobot_kriteria extends Model
{
    protected $table = 'bobot_kriteria';
    protected $primaryKey= "id_bobot_kriteria";
    public $guarded = [];
    public function nilai_kriteria(){
        return $this->belongsTo('App\nilai_kriteria');
    }
}
