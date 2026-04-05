<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログインユーザーはコメントできる()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post("/products/{$product->id}/comment", [
            'content' => 'いい商品です！',
        ]);

        $response->assertStatus(302); // リダイレクトされる場合
        $this->assertDatabaseHas('comments', [
            'content' => 'いい商品です！',
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function 未ログインユーザーはコメントできない()
    {
        $product = Product::factory()->create();

        $response = $this->post("/products/{$product->id}/comment", [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect('/login'); // ログイン画面にリダイレクト
        $this->assertDatabaseCount('comments', 0);
    }

    /** @test */
    public function コメントが未入力の場合はバリデーションエラー()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post("/products/{$product->id}/comment", [
            'content' => '',
        ]);

        $response->assertSessionHasErrors(['content']);
        $this->assertDatabaseCount('comments', 0);
    }

    /** @test */
    public function コメントが255文字以上の場合はバリデーションエラー()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $longText = str_repeat('あ', 256);

        $response = $this->actingAs($user)->post("/products/{$product->id}/comment", [
            'content' => $longText,
        ]);

        $response->assertSessionHasErrors(['content']);
        $this->assertDatabaseCount('comments', 0);
    }
}