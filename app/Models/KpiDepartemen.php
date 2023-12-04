<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpiDepartemen extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'kpi_departemen';
    // public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        // 'id',
        'departemen',
    ];

    public function kpi_team()
    {
        return $this->hasMany(\App\Models\KpiTeam::class,'kpi_departemen_id');
    }
}
