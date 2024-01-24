<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periode extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'periode';
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'id', 'periode', 'status'
    ];
}
