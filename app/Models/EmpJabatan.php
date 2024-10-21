<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpJabatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection= 'emp';
    public $table = 'jabatan';
    public $timestamps = false;
    // public $table = 'biodata_karyawan';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'id',
        'nama_jabatan',
    ];

    // public function itic_departemen()
    // {
    //     return $this->belongsTo(\App\Models\LogPosisi::class, 'nik','nik');
    // }
}
