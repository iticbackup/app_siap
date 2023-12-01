<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekapPelatihanSeminarKategori extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'rekap_pelatihan_seminar_kategori';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'kategori',
    ];
}
