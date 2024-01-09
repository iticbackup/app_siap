<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IjinKeluarMasuk extends Model
{
    use HasFactory;
    protected $connection= 'absensi';
    protected $primaryKey = 'id_ijin';
    public $table = 'ijin_keluar_masuk';
    public $timestamps = false;
    public $incrementing = false;
    // public $table = 'biodata_karyawan';
    // protected $dates = ['deleted_at'];
    public $fillable = [
        'id_ijin',
        'nik',
        'tanggal_ijin',
        'jam_keluar',
        'jam_datang',
        'jam_istirahat',
        'keperluan',
        'nik_op',
        'tanggal_input',
    ];

    public function biodata_karyawan()
    {
        return $this->belongsTo(\App\Models\BiodataKaryawan::class, 'nik','nik');
    }
}
