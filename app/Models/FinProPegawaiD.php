<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class FinProPegawaiD extends Model
{
    use HasFactory;
    protected $connection= 'fin_pro';
    public $table = 'pegawai_d';
    protected $primaryKey = 'pegawai_id';
    public $timestamps = false;
    // public $table = 'biodata_karyawan';
    // protected $dates = ['deleted_at'];
    public $fillable = [
        'pegawai_id',
        'pend_id',
        'gol_darah',
        'stat_nikah',
        'jml_anak',
        'alamat',
        'telp_extra',
        'hubungan',
        'nama_hubungan',
        'agama',
    ];

    // public function biodata_karyawan()
    // {
    //     return $this->belongsTo(\App\Models\BiodataKaryawan::class, 'pin','pegawai_pin');
    // }

    // public function itic_departemen()
    // {
    //     return $this->belongsTo(\App\Models\LogPosisi::class, 'nik','nik');
    // }
}
