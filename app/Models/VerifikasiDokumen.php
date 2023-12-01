<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerifikasiDokumen extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'verifikasi_dokumen';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'kode_barcode',
        'link',
        'status',
    ];
}
