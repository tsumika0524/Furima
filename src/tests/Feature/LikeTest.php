<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * いいねできる
     */
    public function test_user_can_like_product()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()->create();

        $this->actingAs($user)->post("/products/{$product->id}/like");

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    /**
     * いいね数が増加する
     */
    public function test_like_count_increases()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()->create();

        // before
        $this->assertEquals(0, DB::table('likes')->count());

        // 実行
        $this->actingAs($user)->post("/products/{$product->id}/like");

        // after
        $this->assertEquals(1, DB::table('likes')->count());
    }

    /**
     * いいね解除できる（トグル）
     */
    public function test_user_can_unlike_product()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()->create();

        // 事前にいいね
        DB::table('likes')->insert([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // トグル実行（解除）
        $this->actingAs($user)->post("/products/{$product->id}/like");

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    /**
     * いいね済みはアイコンが変化する
     */
    public function test_liked_product_shows_active_icon()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()->create();

        // いいね状態を作る
        DB::table('likes')->insert([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user)
            ->get("/products/{$product->id}");

        $response->assertStatus(200);

        // 🔥 実装に合わせて変更すること
        // 例：class="liked" or "active" など
        $response->assertSee('liked');
    }

    /**
     * 未ログインユーザーはいいねできない
     */
    public function test_guest_cannot_like_product()
    {
        $product = Product::factory()->create();

        $response = $this->post("/products/{$product->id}/like");

        $response->assertRedirect('/login');
    }
}