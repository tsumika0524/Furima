<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'payment_method',
        'total_price',
        'postal_code',
        'address',
        'building',
    ];

    /**
     * 購入者
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 購入商品
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}