<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiStatus extends Model
{
    use HasFactory;
    protected $connection= 'absensi';
    protected $primaryKey = 'status_id';
    public $table = 'att_status';
    public $timestamps = false;
    public $incrementing = false;
    // public $table = 'biodata_karyawan';
    // protected $dates = ['deleted_at'];
    public $fillable = [
        'status_id',
        'status_info',
    ];
}
