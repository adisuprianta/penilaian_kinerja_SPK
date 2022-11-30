<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class karyawan extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey= "id_karyawan";
    public $guarded = [];
    public function setEntryDateAttribute($input){
        $this->attributes['tanggal_lahir'] = 
        Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
    }
}
