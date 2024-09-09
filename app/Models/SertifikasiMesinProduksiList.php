<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikasiMesinProduksiList extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'sertifikasi_mesin_list';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'sertifikasi_mesin_id',
        'tgl_periksa_uji',
        'tgl_terbit_sertifikat',
        'no_sertifikat_terakhir',
        'keterangan',
        'tgl_resertifikat_selanjutnya',
    ];

    public function sertifikasi_mesin_produksi()
    {
        return $this->belongsTo(\App\Models\SertifikasiMesinProduksi::class, 'sertifikasi_mesin_id', 'id');
    }
}
