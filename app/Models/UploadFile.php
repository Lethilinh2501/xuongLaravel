<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadFile extends Model
{
    use HasFactory;
    protected $table = 'upload_files';
    protected $fillable = [
        'id',
        'user_id',
        'file_name',
        'file_path',
        'file_type'
    ];
}
