<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpiDetail extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'kpi_detail';
    // public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        // 'id',
        'kpi_id',
        'indikator',
        'target_nilai',
        'target_keterangan',
        'realisasi_nilai',
        'realisasi_keterangan',
        'pencapaian',
        'bobot',
        'nilai',
        'skor',
        'keterangan',
    ];
}
