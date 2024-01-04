<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class FinPro extends Model
{
    use HasFactory;
    protected $connection= 'fin_pro';
    public $table = 'att_log';
    public $timestamps = false;
    // public $table = 'biodata_karyawan';
    // protected $dates = ['deleted_at'];
    public $fillable = [
        'scan_date',
        'pin',
        'verifymode',
        'inoutmode',
        'reserved',
        'work_code',
    ];

    public function biodata_karyawan()
    {
        return $this->belongsTo(\App\Models\BiodataKaryawan::class, 'pin','pin');
    }

    // public function itic_departemen()
    // {
    //     return $this->belongsTo(\App\Models\LogPosisi::class, 'nik','nik');
    // }
}
