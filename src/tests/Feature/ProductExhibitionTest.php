<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductExhibitionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 商品出品が正しく保存される
     */
    public function test_product_can_be_created_with_all_fields()
{
    Storage::fake('public');

    $this->withoutMiddleware(\Illuminate\Auth\Middleware\EnsureEmailIsVerified::class);

    $user = User::factory()->create();
    $user->markEmailAsVerified();

    $category = Category::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('sell.store'), [
        'name' => 'テスト商品',
        'brand' => 'ナイキ',
        'description' => 'とても良い商品です',
        'price' => 5000,
        'condition' => '新品',
        'categories' => [$category->id],
        'image' => UploadedFile::fake()->create('test.jpg'), // ★追加
    ]);

    $response->assertStatus(302);

    $this->assertDatabaseHas('products', [
        'user_id' => $user->id,
        'name' => 'テスト商品',
        'brand' => 'ナイキ',
        'description' => 'とても良い商品です',
        'price' => 5000,
        'item_condition' => '新品',
    ]);

    $product = Product::first();

    $this->assertDatabaseHas('category_product', [
        'product_id' => $product->id,
        'category_id' => $category->id,
    ]);
}
}