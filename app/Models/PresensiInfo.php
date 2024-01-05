<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiInfo extends Model
{
    use HasFactory;
    protected $connection= 'absensi';
    protected $primaryKey = 'att_rec';
    public $table = 'att_presensi_info';
    public $timestamps = false;
    public $incrementing = false;
    // public $table = 'biodata_karyawan';
    // protected $dates = ['deleted_at'];
    public $fillable = [
        'att_id',
        'scan_date',
        'pin',
        'inoutmode',
        'status',
        'keterangan',
    ];

    public function biodata_karyawan()
    {
        return $this->belongsTo(\App\Models\BiodataKaryawan::class, 'pin','pin');
    }

    public function presensi_status()
    {
        return $this->belongsTo(\App\Models\PresensiStatus::class, 'status');
    }
}
