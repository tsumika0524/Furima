<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductIndexTest extends TestCase
{
    use RefreshDatabase;

    /** 全商品が表示される */
    public function test_全商品を取得できる()
    {
        $user = User::factory()->create();

        Product::create([
            'name' => '商品A',
            'user_id' => $user->id,
            'price' => 1000,
            'description' => 'テスト商品A',
            'item_condition' => '新品',
            'is_sold' => false,
        ]);

        Product::create([
            'name' => '商品B',
            'user_id' => $user->id,
            'price' => 2000,
            'description' => 'テスト商品B',
            'item_condition' => '新品',
            'is_sold' => false,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('商品A');
        $response->assertSee('商品B');
    }

    /** 購入済み商品はSold表示 */
    public function test_購入済み商品はsoldと表示される()
    {
        $user = User::factory()->create();

        Product::create([
            'name' => '売り切れ商品',
            'user_id' => $user->id,
            'price' => 3000,
            'description' => 'テスト商品',
            'item_condition' => '新品',
            'is_sold' => true, // ← あなたのカラムに合わせて変更
        ]);

        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    /** 自分の商品は表示されない */
    public function test_自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();

        // 自分の商品
        Product::create([
            'name' => '自分の商品',
            'user_id' => $user->id,
            'price' => 1000,
            'description' => 'テスト商品',
            'item_condition' => '新品',
            'is_sold' => false,
        ]);

        // 他人の商品
        $otherUser = User::factory()->create();

        Product::create([
            'name' => '他人の商品',
            'user_id' => $otherUser->id,
            'price' => 2000,
            'description' => 'テスト商品',
            'item_condition' => '新品',
            'is_sold' => false,
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);

        // 自分の商品は表示されない
        $response->assertDontSee('自分の商品');

        // 他人の商品は表示される
        $response->assertSee('他人の商品');
    }
}