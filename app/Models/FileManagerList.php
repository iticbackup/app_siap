<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileManagerList extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'file_manager_list';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'file_manager_category_id',
        'no_dokumen',
        'title',
        'files',
    ];

    public function file_manager_category()
    {
        return $this->belongsTo(\App\Models\FileManagerCategory::class, 'file_manager_category_id');
    }
}
