<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(), 
            'name' => $this->faker->word(),
            'brand' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => 1000,
            'item_condition' => '新品',
            'image' => null,
            'is_sold' => false,
        ];
    }
}