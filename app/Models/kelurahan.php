<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;
    protected $fillable = ['kode_kel','nama_kel','kecamatan_id'];
    public $timestamps = true;

    public function Kecamatan(){
        return $this->belongsTo("App\Models\Kecamatan",'kecamatan_id');
    }

    public function Rw(){
        return $this->hasMany('App\Models\Rw','rw_id');
    }
}