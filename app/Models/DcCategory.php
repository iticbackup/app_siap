<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DcCategory extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'dc_category';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function dc_category_departemen()
    {
        return $this->belongsTo(\App\Models\DcCategoryDepartemen::class, 'dc_category_departemen_id','id');
    }
}
