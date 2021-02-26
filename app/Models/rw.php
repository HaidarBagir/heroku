<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rw extends Model
{

    public $table = 'rws';
    protected $fillable = ['kode_rw','nama_rw','kelurahan_id'];
    public $timestamps = true;

    public function Kelurahan(){
        return $this->belongsTo('App\Models\Kelurahan','kelurahan_id');
    }
}

