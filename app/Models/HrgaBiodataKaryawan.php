<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrgaBiodataKaryawan extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'hrga_biodata_karyawan_new';
    // protected $dates = ['deleted_at'];
    
    public $incrementing = false;

    public $fillable = [
        'id',
        // 'no_urut_level',
        // 'no_urut_departemen',
        'nik',
        'no_npwp',
        'no_telepon',
        'no_bpjs_ketenagakerjaan',
        'no_bpjs_kesehatan',
        'no_rekening_mandiri',
        'no_rekening_bws',
        'no_rekening_bca',
        'departemen_dept',
        'departemen_bagian',
        // 'departemen_jml',
        'departemen_level',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'kecamatan',
        'kelurahan',
        'kab_kota',
        'provinsi',
        'jenis_kelamin',
        'status_keluarga',
        'golongan_darah',
        'pendidikan',
        'email',
        'kunci_loker',
        'sim_kendaraan',
        'foto_karyawan',
        'status_karyawan',
        'tanggal_resign',
    ];

    public function biodata_karyawan()
    {
        return $this->belongsTo(\App\Models\BiodataKaryawan::class, 'nik','nik');
    }

    public function biodata_nama_karyawan()
    {
        return $this->belongsTo(\App\Models\BiodataKaryawan::class, 'nama','nama');
    }

    public function log_posisi()
    {
        return $this->belongsTo(\App\Models\LogPosisi::class, 'nik','nik');
    }

    // public function has_log_posisi()
    // {
    //     return $this->hasMany(\App\Models\LogPosisi::class, 'nik','nik');
    // }

    public function status_kerja()
    {
        return $this->hasMany(\App\Models\HrgaStatusKerja::class, 'hrga_biodata_karyawan_id')->orderBy('id','desc');
    }

    public function riwayat_konseling()
    {
        return $this->hasMany(\App\Models\HrgaRiwayatKonselingKaryawan::class, 'hrga_biodata_karyawan_id');
    }

    public function riwayat_training()
    {
        return $this->hasMany(\App\Models\HrgaRiwayatTraining::class, 'hrga_biodata_karyawan_id');
    }

    public function status_karyawan_resign()
    {
        return $this->belongsTo(\App\Models\HrgaKaryawanResign::class, 'hrga_biodata_karyawan_id');
    }

    // public function group_departemen_level()
    // {
    //     return $this->hasMany(\App\Models\HrgaBiodataKaryawan::class,'id','')->groupBy('departemen_level');
    // }
}
