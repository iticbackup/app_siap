<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpiCulture extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'kpi_culture';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'culture',
        'indikator',
        // 'skala',
        // 'bobot',
    ];
}
