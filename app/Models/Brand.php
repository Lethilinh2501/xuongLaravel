<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'logo'
    ];
    public function product()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }
}
