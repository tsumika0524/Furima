<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseAddressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 住所変更後に購入画面へ反映される
     */
    public function test_address_reflects_on_purchase_screen()
    {
        $user = User::factory()->create([
        'postal_code' => '123-4567',
        'address' => '東京都渋谷区1-1-1',
        'building' => null,
        ]);
        $product = Product::factory()->create();

        // ログイン
        $this->actingAs($user);

        // 住所変更
        $this->post('/address/update', [
            'address' => '東京都渋谷区1-1-1'
        ]);

        // 購入画面アクセス
        $response = $this->get("/purchase/{$product->id}");

        // 画面に新住所が表示されているか
        $response->assertSee('東京都渋谷区1-1-1');
    }

    /**
     * 購入時に住所が紐づいて保存される
     */
    public function test_address_is_saved_with_order()
{
    $user = User::factory()->create([
        'postal_code' => '123-4567',
        'address' => '東京都新宿区2-2-2',
        'building' => null,
    ]);

    $product = Product::factory()->create([
        'price' => 1000,
        'is_sold' => false,
    ]);

    
    $this->actingAs($user)
        ->get("/purchase/success/{$product->id}");

    
    $this->assertDatabaseHas('purchases', [
        'user_id' => $user->id,
        'product_id' => $product->id,
        'address' => '東京都新宿区2-2-2',
    ]);
}
}