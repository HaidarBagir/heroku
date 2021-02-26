<?php

namespace App\Models;
use App\Models\Kota;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class provinsi extends Model
{
    use HasFactory;

    protected $filable=['kode_prov','nama_prov'];
    public $timestamps;
    
    public function kota(){
         return $this->hasMany('App\Models\Kota','id_provinsi');
    }
}
