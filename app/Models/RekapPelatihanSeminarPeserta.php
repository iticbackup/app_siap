<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekapPelatihanSeminarPeserta extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'rekap_pelatihan_seminar_peserta';
    // public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'rekap_pelatihan_seminar_id',
        'peserta',
        'departemen_id',
    ];

    public function rekap_pelatihan_seminar()
    {
        return $this->hasMany(\App\Models\RekapPelatihanSeminar::class, 'id');
    }
}
