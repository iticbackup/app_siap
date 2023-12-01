<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartemenUser extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'departemen_user';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'nik',
        'departemen_id',
        'staff',
        'team',
    ];

    public function departemen()
    {
        return $this->belongsTo(\App\Models\Departemen::class, 'departemen_id');
    }
    public function rekap_pelatihan_seminar_peserta()
    {
        return $this->hasMany(\App\Models\RekapPelatihanSeminarPeserta::class, 'peserta');
    }
}
