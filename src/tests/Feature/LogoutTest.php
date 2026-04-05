<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** ログアウトできる */
    public function test_ログアウトできる()
    {
        // ユーザー作成
        $user = User::factory()->create();

        // ログイン状態にする
        $this->actingAs($user);

        // ログアウト実行（FortifyはPOST）
        $response = $this->post('/logout');

        // ログアウト確認
        $this->assertGuest();

        // リダイレクト確認（環境に応じて変更）
        $response->assertRedirect('/');
    }
}