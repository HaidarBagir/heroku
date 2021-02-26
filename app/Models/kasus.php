<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kasus extends Model
{
    use HasFactory;

    protected $fillable = ['positif','sembuh','meninggal','tanggal','rw_id'];
    public $timestamps = true;

    public function Rw(){
        return $this->belongsTo('App\Models\Rw','rw_id');
    }
}