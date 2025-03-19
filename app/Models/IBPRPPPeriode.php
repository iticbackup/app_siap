<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IBPRPPPeriode extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'ibprpp_periode';
    protected $dates = ['deleted_at'];
    // public $incrementing = false;

    public $fillable = [
        'periode',
        'status',
    ];
}
