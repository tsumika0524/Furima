<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;      
use App\Models\Product;

class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
{
    return [
        'user_id' => User::factory(),
        'product_id' => Product::factory(),
        'address' => 'テスト住所',
        'postal_code' => '123-4567',
        'payment_method' => 'card',
        'total_price' => 5000,
    ];
}
}
