<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class FinProPegawai extends Model
{
    use HasFactory;
    protected $connection= 'fin_pro';
    public $table = 'pegawai';
    protected $primaryKey = 'pegawai_id';
    public $timestamps = false;
    // public $table = 'biodata_karyawan';
    // protected $dates = ['deleted_at'];
    public $fillable = [
        'pegawai_id',
        'pegawai_pin',
        'pegawai_nip',
        'pegawai_nama',
        'pegawai_alias',
        'pegawai_pwd',
        'pegawai_rfid',
        'pegawai_privilege',
        'pegawai_telp',
        'pegawai_status',
        'tempat_lahir',
        'tgl_lahir',
        'pembagian1_id',
        'pembagian2_id',
        'pembagian3_id',
        'tgl_mulai_kerja',
        'tgl_resign',
        'gender',
        'tgl_masuk_pertama',
        'photo_path',
        'tmp_img',
        'nama_bank',
        'nama_rek',
        'no_rek',
        'new_pegawai_id',
    ];

    public function biodata_karyawan()
    {
        return $this->belongsTo(\App\Models\BiodataKaryawan::class, 'pin','pegawai_pin');
    }

    // public function itic_departemen()
    // {
    //     return $this->belongsTo(\App\Models\LogPosisi::class, 'nik','nik');
    // }
}
