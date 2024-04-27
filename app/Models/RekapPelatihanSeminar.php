<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekapPelatihanSeminar extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'rekap_pelatihan_seminar';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'tanggal',
        'tema',
        'kategori_pelatihan',
        'penyelenggara',
        'jenis',
        'jml_hari',
        'jml_jam_dlm_hari',
        'total_peserta',
        // 'peserta',
        'periode',
        'keterangan',
        'status',
        'check_date',
        'file_sertifikat',
        'file_absensi',
        'link',
    ];

    public function rekap_pelatihan_seminar_peserta()
    {
        return $this->hasMany(\App\Models\RekapPelatihanSeminarPeserta::class, 'rekap_pelatihan_seminar_id');
    }
}
