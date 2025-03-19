<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IBPRPP extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'ibprpp';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    public $incrementing = false;

    public $fillable = [
        'id',
        'ibprpp_periode_id',
        'ibprpp_category_area_id',
        'ibprpp_departemen_id',
        // 'departemen_id',
        'aktivitas_pekerja',
        'jenis_aktivitas',
        'body',
        // 'penilaian_risiko_pengendalian',
        // 'potensi_bahaya',
        // 'risiko_bahaya',
        // 'penilaian_risiko',
        // 'nilai_risiko',
        // 'penetapan_pengendali',
        // 'pengendali',
        // 'pic_wewenang',
        // 'regulasi_terkait',
        'status',
    ];

    public function ibprpp_periode()
    {
        return $this->belongsTo(\App\Models\IBPRPPPeriode::class, 'ibprpp_periode_id', 'id')->select('periode');
    }

    public function ibprpp_category_area()
    {
        return $this->belongsTo(\App\Models\IBPRPPCategoryArea::class, 'ibprpp_category_area_id', 'id')->select('category_area');
    }

    public function ibprpp_departemen()
    {
        return $this->belongsTo(\App\Models\IBPRPPDepartemen::class, 'ibprpp_departemen_id', 'id')->select('departemen');
    }
}
