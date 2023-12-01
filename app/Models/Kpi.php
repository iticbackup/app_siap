<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kpi extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'kpi';
    // public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        // 'id',
        'kpi_team_id',
        'periode',
        'nilai',
        'status_nilai',
        'mengetahui',
        'penilai',
        'yang_dinilai',
        'status_mengetahui',
        'status_penilai',
        'remaks',
    ];

    public function kpi_team()
    {
        return $this->belongsTo(\App\Models\KpiTeam::class,'kpi_team_id');
    }

    public function kpi_detail()
    {
        return $this->hasMany(\App\Models\KpiDetail::class, 'kpi_id');
    }
}
