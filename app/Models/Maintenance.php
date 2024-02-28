<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maintenance extends Model
{
    use HasFactory;
    public $table = 'maintenance';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'name',
        'secret',
        'redirect',
        'status',
    ];
}
