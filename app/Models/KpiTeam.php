<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpiTeam extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'kpi_team';
    // public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        // 'id',
        'departemen_user_id',
        'kpi_departemen_id',
        'jabatan',
    ];

    public function kpi()
    {
        return $this->belongsTo(\App\Models\Kpi::class, 'id');
    }
    public function departemen_user()
    {
        return $this->belongsTo(\App\Models\DepartemenUser::class, 'departemen_user_id');
    }
    public function kpi_departemen()
    {
        return $this->belongsTo(\App\Models\KpiDepartemen::class, 'kpi_departemen_id');
    }
}
