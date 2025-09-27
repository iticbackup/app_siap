<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListValidasiDisetujui extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'dc_list_validasi_disetujui';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function departemen()
    {
        return $this->belongsTo(\App\Models\Departemen::class, 'departemen_id', 'id');
    }
}
