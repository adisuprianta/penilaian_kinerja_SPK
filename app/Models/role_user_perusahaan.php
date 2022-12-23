<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role_user_perusahaan extends Model
{
    protected $table = 'role_user_perusahaan';
    protected $primaryKey= "user_id";
    public $guarded = [];
    // public function user()
    // {
    // 	return $this->belongsTo('App\User');
    // }
}
