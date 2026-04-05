<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** 商品を購入できる（success経由） */
    public function test_商品を購入できる()
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => null,
        ]);

        $product = Product::factory()->create([
            'name' => '商品A',
            'price' => 1000,
            'is_sold' => false,
        ]);

        // ⭐ Stripeの代わりに success を叩く
        $response = $this->actingAs($user)
            ->get("/purchase/success/{$product->id}");

        $response->assertRedirect('/');

        // ✅ 商品が売却済みになる
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_sold' => true,
        ]);

        // ✅ 購入データが保存される
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => 'stripe',
            'total_price' => 1000,
            'address' => '東京都渋谷区1-1-1',
        ]);
    }

    /** 商品一覧でSold表示 */
    public function test_購入商品は一覧でsold表示される()
    {
        $product = Product::factory()->create([
            'name' => '売り切れ商品',
            'is_sold' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /** プロフィールに購入商品が表示される */
public function test_購入商品がプロフィールに表示される()
{
    // 購入者（←これが無いと今回のエラーになる）
    $user = User::factory()->create();

    // 出品者
    $seller = User::factory()->create();

    // 商品
    $product = Product::factory()->create([
        'name' => '購入済み商品',
        'user_id' => $seller->id,
        'is_sold' => true,
    ]);

    // 購入履歴
    \DB::table('purchases')->insert([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'payment_method' => 'stripe',
        'total_price' => 3000,
        'postal_code' => '123-4567',
        'address' => '東京都新宿区1-1-1',
        'building' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // ログインしてマイページ
    $response = $this->actingAs($user)
        ->get('/mypage?tab=buy');

    $response->assertStatus(200);
    $response->assertSee('購入済み商品');
}
}