<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** 名前未入力 */
    public function test_名前が未入力の場合エラー()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください'
        ]);
    }

    /** メール未入力 */
    public function test_メール未入力でエラー()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'test',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
        ]);
    }

    /** パスワード未入力 */
    public function test_パスワード未入力でエラー()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    /** パスワード7文字以下 */
    public function test_パスワードが短いとエラー()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください'
        ]);
    }

    /** パスワード不一致 */
    public function test_パスワード不一致でエラー()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'different',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません'
        ]);
    }

    /** 正常登録 */
    public function test_正常に会員登録できる()
    {
        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // DBに保存されているか
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        // 画面遷移（環境に応じて変更）
        $response->assertRedirect('/profile');
    }
}

