<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpiBobot extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'kpi_bobot';
    // public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        // 'id',
        'bobot_huruf',
        'bobot_nilai',
        'keterangan',
        'skala',
        'prosentase',
    ];
}
