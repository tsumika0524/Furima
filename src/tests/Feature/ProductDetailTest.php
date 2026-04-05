<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    /** 必要な情報がすべて表示される */
    public function test_商品詳細に必要な情報が表示される()
    {
        // ユーザー
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // 商品
        $product = Product::create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 1000,
            'description' => 'これは説明です',
            'item_condition' => '新品',
            'user_id' => $user->id,
            'is_sold' => false,
        ]);

        // カテゴリ
        $category = Category::create([
            'name' => '家電',
        ]);

        // 中間テーブル
        $product->categories()->attach($category->id);

        // コメント
        Comment::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => 'いい商品です',
        ]);

        // いいね（likesテーブルある前提）
        \DB::table('likes')->insert([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // 実行
        $response = $this->get('/products/' . $product->id);

        $response->assertStatus(200);

        // 表示確認
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('1,000');
        $response->assertSee('これは説明です');
        $response->assertSee('新品');

        // カテゴリ
        $response->assertSee('家電');

        // コメント
        $response->assertSee('いい商品です');
        $response->assertSee('テストユーザー');
    }

    /** 複数カテゴリが表示される */
    public function test_複数カテゴリが表示される()
    {
        $user = User::create([
            'name' => 'ユーザー',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'name' => 'カテゴリ商品',
            'brand' => 'ブランド',
            'price' => 1000,
            'description' => '説明',
            'item_condition' => '良好',
            'user_id' => $user->id,
            'is_sold' => false,
        ]);

        // カテゴリ2つ
        $cat1 = Category::create(['name' => '家電']);
        $cat2 = Category::create(['name' => 'ゲーム']);

        $product->categories()->attach([$cat1->id, $cat2->id]);

        $response = $this->get('/products/' . $product->id);

        $response->assertStatus(200);

        $response->assertSee('家電');
        $response->assertSee('ゲーム');
    }
}