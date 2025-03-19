<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IBPRPPCategoryArea extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'ibprpp_category_area';
    protected $dates = ['deleted_at'];
    // public $incrementing = false;

    public $fillable = [
        'category_area',
        'status',
    ];
}
