<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class LogPosisi extends Model
{
    use HasFactory;
    protected $connection= 'emp';
    public $table = 'log_posisi';
    public $timestamps = false;
    // public $table = 'biodata_karyawan';
    // protected $dates = ['deleted_at'];
    public $fillable = [
        'id',
        'nik',
        'id_posisi',
        'id_jabatan',
        'satuan_kerja',
        'tanggal',
    ];

    // public function jabatan()
    // {
    //     return $this->belongsTo(\App\Models\EmpJabatan::class, 'satuan_kerja','satuan_kerja');
    // }
}
