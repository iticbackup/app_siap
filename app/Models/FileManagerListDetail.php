<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileManagerListDetail extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'file_manager_list_detail';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'file_manager_list_id',
        'title',
        'files',
    ];
}
