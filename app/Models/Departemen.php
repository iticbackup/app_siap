<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departemen extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'departemen';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'departemen',
    ];

    public function departemen_user()
    {
        return $this->belongsTo(\App\Models\DepartemenUser::class, 'id');
    }

    public function departemen_user_all()
    {
        return $this->hasMany(\App\Models\DepartemenUser::class, 'departemen_id');
    }

    public function file_manager_category()
    {
        return $this->belongsTo(\App\Models\FileManagerCategory::class, 'departemen_id');
    }
}
