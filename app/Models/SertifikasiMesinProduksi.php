<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikasiMesinProduksi extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'sertifikasi_mesin';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'jenis_mesin',
        'no_sertifikat',
        'tgl_sertifikat_pertama',
        'periode_resertifikasi',
    ];

    public function sertifikasi_mesin_produksi_list()
    {
        return $this->hasMany(\App\Models\SertifikasiMesinProduksiList::class, 'sertifikasi_mesin_id', 'id');
    }
}
