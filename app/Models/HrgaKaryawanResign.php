<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrgaKaryawanResign extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'hrga_karyawan_resign';
    protected $dates = ['deleted_at'];
    public $incrementing = false;

    public $fillable = [
        'id',
        'hrga_biodata_karyawan_id',
        'tanggal_resign',
    ];

    public function hrga_biodata_karyawan()
    {
        return $this->belongsTo(\App\Models\HrgaBiodataKaryawan::class, 'hrga_biodata_karyawan_id');
    }
}
