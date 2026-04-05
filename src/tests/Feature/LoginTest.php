<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** メール未入力 */
    public function test_メールアドレス未入力でエラー()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
        ]);
    }

    /** パスワード未入力 */
    public function test_パスワード未入力でエラー()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    /** ログイン失敗 */
    public function test_ログイン情報が間違っている場合エラー()
    {
        // ユーザーは作らない（存在しない状態）

        $response = $this->from('/login')->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'password',
        ]);

        // Fortifyはerrorsじゃなくてセッションメッセージの場合あり
        $response->assertSessionHasErrors(); 
        // もしくは ↓（実装によって切り替え）
        // $response->assertSessionHas('errors');
    }

    /** 正常ログイン */
    public function test_正しい情報でログインできる()
    {
        // ユーザー作成
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // 認証確認
        $this->assertAuthenticatedAs($user);

        // リダイレクト確認（環境に合わせる）
        $response->assertRedirect('/profile');
    }
}