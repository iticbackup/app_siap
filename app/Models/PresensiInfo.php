<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiInfo extends Model
{
    use HasFactory;
    protected $connection= 'absensi';
    public $table = 'att_presensi_info';
    public $timestamps = false;
    // public $table = 'biodata_karyawan';
    // protected $dates = ['deleted_at'];
    public $fillable = [
        'att_id',
        'scan_date',
        'pin',
        'status',
        'keterangan',
    ];
}
