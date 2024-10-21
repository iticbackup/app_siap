<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IticDepartemen extends Model
{
    use HasFactory,SoftDeletes;
    protected $connection= 'emp';
    public $table = 'departemen';
    // protected $primaryKey = 'id_departemen';
    // public $timestamps = false;
    public $incrementing = false;
    // public $table = 'biodata_karyawan';
    // protected $dates = ['deleted_at'];
    public $fillable = [
        'id',
        'nama_departemen',
    ];

    // public function itic_departemen()
    // {
    //     return $this->belongsTo(\App\Models\LogPosisi::class, 'nik','nik');
    // }
}
