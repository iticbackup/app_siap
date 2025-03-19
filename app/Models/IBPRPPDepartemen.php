<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IBPRPPDepartemen extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'ibprpp_departemen';
    protected $dates = ['deleted_at'];
    // public $incrementing = false;

    public $fillable = [
        'departemen',
        'status',
    ];
}
