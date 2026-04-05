<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Purchase;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'brand',
    'description',
    'price',
    'item_condition',
    'image',
    'user_id',
    'is_sold',
    ];

    // いいね
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($user)
    {
    if (!$user) return false;

    return $this->likes()
        ->where('user_id', $user->id)
        ->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
    return $this->belongsToMany(\App\Models\Category::class);
    }

    public function purchase()
    {
    return $this->hasOne(Purchase::class);
    }

    public function isSold()
    {
    return $this->is_sold;
    }

    public function likesCount()
    {
    return $this->likes()->count();
    }

    public function commentsCount()
    {
    return $this->comments()->count();
    }
    
}

