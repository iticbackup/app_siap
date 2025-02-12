<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class EmpPosisi extends Model
{
    use HasFactory;
    protected $connection= 'emp';
    public $table = 'posisi';
    public $timestamps = false;
    // public $table = 'biodata_karyawan';
    // protected $dates = ['deleted_at'];
    public $fillable = [
        'id',
        'id_jabatan',
        'nama_posisi',
    ];

    // public function itic_departemen()
    // {
    //     return $this->belongsTo(\App\Models\LogPosisi::class, 'nik','nik');
    // }
}
