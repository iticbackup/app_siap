<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpiCultureVerifikasi extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'kpi_culture_verifikasi';
    // protected $primaryKey = 'id';
    // public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'user_id',
        'status',
        // 'skala',
        // 'bobot',
    ];
}
