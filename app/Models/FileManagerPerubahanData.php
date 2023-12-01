<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileManagerPerubahanData extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    public $table = 'file_manager_perubahan_data';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'departemen_id',
        'kode_formulir',
        'tanggal_formulir',
        'disetujui_signature',
        'pengajuan_signature',
        'represtative_signature',
        'is_open',
        'status',
        'remaks',
    ];

    public function departemen()
    {
        return $this->belongsTo(\App\Models\Departemen::class, 'departemen_id');
    }
    
    public function file_manager_perubahan_data_detail()
    {
        return $this->hasMany(\App\Models\FileManagerPerubahanDataDetail::class, 'file_manager_perubahan_data_id');
    }

}
