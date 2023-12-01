<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modules extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'module';
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'title', 'files'
    ];
}
