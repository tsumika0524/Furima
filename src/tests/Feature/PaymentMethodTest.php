<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    /** 支払い方法を選択できる */
    public function test_支払い方法を選択できる()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post("/purchase/{$product->id}/payment", [
            'payment_method' => 'card',
        ]);

        $response->assertSessionHas('payment_method', 'credit_card');
    }

    /** 小計画面に反映される */
    public function test_小計画面に支払い方法が反映される()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $user->id,
        ]);

        // セッションに保存（擬似的に選択済み状態）
        $this->withSession([
            'payment_method' => 'credit_card'
        ]);

        $response = $this->actingAs($user)
            ->get("/purchase/{$product->id}");

        $response->assertStatus(200);

        // 表示確認（画面に出ている文字に合わせて調整）
        $response->assertSee('カード支払い');
    }

    /** 未選択の場合エラー */
    public function test_支払い方法未選択でエラー()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->post("/purchase/{$product->id}/payment", [
                'payment_method' => '',
            ]);

        $response->assertSessionHasErrors('payment_method');
    }
}