<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    /**
     * プロフィール編集画面に初期値が表示される
     */
    public function test_profile_edit_form_has_initial_values()
    {
        // ユーザー作成（初期値あり）
        $user = User::factory()->create([
            'name' => '山田太郎',
            'profile_image' => 'profile.jpg',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
        ]);

        // ログイン
        $this->actingAs($user);

        // 編集画面へアクセス
        $response = $this->get('/profile');

        // ステータス確認
        $response->assertStatus(200);

        // 各初期値が表示されているか
        $response->assertSee('山田太郎');
        $response->assertSee('profile.jpg');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区1-1-1');
    }
}