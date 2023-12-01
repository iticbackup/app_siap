<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class LogPosisi extends Model
{
    use HasFactory;
    protected $connection= 'emp';
    public $table = 'log_posisi';
    public $timestamps = false;
    // public $table = 'biodata_karyawan';
    // protected $dates = ['deleted_at'];
    public $fillable = [
        'id',
        'nik',
        'tanggal',
    ];
}
