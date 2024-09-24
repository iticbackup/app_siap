<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinProDeviceType extends Model
{
    use HasFactory;
    protected $connection= 'fin_pro';
    public $table = 'dev_type';
    public $timestamps = false;

    public $fillable = [
        'dev_type',
        'id_type',
        'type',
    ];
}
