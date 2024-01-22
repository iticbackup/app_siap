<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpiTotalNilai extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'kpi_total_nilai';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'kpi_id',
        'nama_kpi',
        'bobot',
        'nilai',
        'total_nilai',
        'skor_nilai',
        'keterangan',
        // 'skala',
        // 'bobot',
    ];
}
