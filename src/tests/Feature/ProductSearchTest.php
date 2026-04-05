<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    /** 商品名で部分一致検索できる */
    public function test_商品名で部分一致検索ができる()
    {
        $user = User::factory()->create();

        Product::create([
            'name' => 'りんごジュース',
            'user_id' => $user->id,
            'price' => 100,
            'description' => 'テスト',
            'item_condition' => '新品',
            'is_sold' => false,
        ]);

        Product::create([
            'name' => 'みかんジュース',
            'user_id' => $user->id,
            'price' => 200,
            'description' => 'テスト',
            'item_condition' => '新品',
            'is_sold' => false,
        ]);

        // 「りんご」で検索
        $response = $this->get('/?keyword=りんご');

        $response->assertStatus(200);

        // 部分一致
        $response->assertSee('りんごジュース');

        // 他は出ない
        $response->assertDontSee('みかんジュース');
    }

    /** 検索状態がマイページでも保持されている */
    public function test_検索状態がマイページでも保持されている()
    {
        $user = User::factory()->create();

        Product::create([
            'name' => 'りんごジュース',
            'user_id' => $user->id,
            'price' => 100,
            'description' => 'テスト',
            'item_condition' => '新品',
            'is_sold' => false,
        ]);

        Product::create([
            'name' => 'みかんジュース',
            'user_id' => $user->id,
            'price' => 200,
            'description' => 'テスト',
            'item_condition' => '新品',
            'is_sold' => false,
        ]);

        // 検索実行
        $this->get('/?keyword=りんご');

        // マイページへ（ログイン必要）
        $response = $this->actingAs($user)->get('/mypage?keyword=りんご');

        $response->assertStatus(200);

        // keywordが保持されているか（inputに入ってる）
        $response->assertSee('value="りんご"', false);
    }
}