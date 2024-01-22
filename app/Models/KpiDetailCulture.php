<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpiDetailCulture extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'kpi_detail_culture';
    // protected $primaryKey = 'id';
    // public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'kpi_id',
        'culture',
        'indikator',
        'skala',
        'bobot',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id','id');
    }
}
