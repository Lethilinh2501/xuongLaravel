<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    use HasFactory;
    protected $table = 'product_comments';
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'comment',
        'rating'
    ];
}
