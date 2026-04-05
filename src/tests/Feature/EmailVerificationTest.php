<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 会員登録後に認証メールが送信される
     */
    public function test_verification_email_is_sent_after_registration()
    {
        Notification::fake();

        // 会員登録
        $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $user = User::first();

        // メール送信確認
        Notification::assertSentTo(
            $user,
            VerifyEmail::class
        );
    }
}