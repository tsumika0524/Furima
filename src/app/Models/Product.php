<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand_name',
        'price',
        'description',
        'user_id'
    ];

    // ⭐ これを追加
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
