<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrgaRiwayatKonselingKaryawan extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'hrga_riwayat_konseling_karyawan';
    protected $dates = ['deleted_at'];
    public $incrementing = false;

    public $fillable = [
        'id',
        'hrga_biodata_karyawan_id',
        'riwayat_konseling',
    ];
}
