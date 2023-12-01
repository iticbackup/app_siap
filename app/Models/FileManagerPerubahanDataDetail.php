<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileManagerPerubahanDataDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    public $table = 'file_manager_perubahan_data_detail';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'file_manager_perubahan_data_id',
        'no_dokumen',
        'halaman',
        'kategori_file',
        'revisi',
        'uraian_perubahan',
        'files',
    ];

    public function file_manager_perubahan_data()
    {
        return $this->belongsTo(\App\Models\FileManagerPerubahanData::class, 'file_manager_perubahan_data_id');
    }

}
