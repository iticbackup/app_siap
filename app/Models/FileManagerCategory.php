<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileManagerCategory extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'file_manager_category';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'departemen_id',
        'kategori',
    ];

    public function departemen()
    {
        return $this->belongsTo(\App\Models\Departemen::class, 'departemen_id');
    }

    public function file_manager_list()
    {
        return $this->hasMany(\App\Models\FileManagerList::class, 'file_manager_category_id');
    }
}
