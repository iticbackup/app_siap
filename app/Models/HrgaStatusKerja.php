<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrgaStatusKerja extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'hrga_status_kerja';
    protected $dates = ['deleted_at'];
    public $incrementing = false;

    public $fillable = [
        'id',
        'hrga_biodata_karyawan_id',
        'pk',
        'ke',
        'tgl_mulai'
    ];
}
