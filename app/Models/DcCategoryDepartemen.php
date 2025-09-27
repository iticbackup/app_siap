<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DcCategoryDepartemen extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'dc_category_departemen';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function dc_category()
    {
        return $this->belongsTo(\App\Models\DcCategory::class, 'dc_category_id','id');
    }

    public function departemen()
    {
        return $this->belongsTo(\App\Models\Departemen::class, 'departemen_id','id');
    }
}
