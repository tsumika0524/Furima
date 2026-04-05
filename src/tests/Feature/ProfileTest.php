<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * プロフィールページに必要な情報が表示される
     */
    public function test_profile_page_displays_user_information()
{
    $user = User::factory()->create([
        'name' => 'テストユーザー',
        'profile_image' => 'test.jpg',
    ]);

    $this->actingAs($user);

    $response = $this->get('/profile');

    $response->assertStatus(200);

    
    $response->assertSee('テストユーザー');

    
    $response->assertSee('test.jpg');

    $response->assertSee('ユーザー名');
    $response->assertSee('郵便番号');
    $response->assertSee('住所');
}
}