<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    public function test_login_logout_success()
    {
        // 檢查登入請求
        $response = $this->postJson('/api/sessions', [
            'user_name' => 'admin',
            'password' => 'AdminPassword123@@@'
        ]);

        // 檢查登入響應
        $response->assertStatus(200)
                    ->assertJson(['success' => true])
                    ->assertJsonStructure(['msg', 'token']); // 驗證鍵

        // 获取登录后返回的令牌
        $token = $response->json('token');

        // 模拟登出请求，并将令牌包含在请求头中
        $logoutResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token, // 加Bearer令牌
        ])->deleteJson('/api/sessions');

        // 檢查登出響應
        $logoutResponse->assertStatus(200)
                        ->assertJson(['success' => true])
                        ->assertJsonStructure(['msg']);
    }

    public function test_login_failure()
    {
        // 模擬错误登入請求
        $response = $this->postJson('/api/sessions', [
            'user_name' => 'admin',
            'password' => 'WrongPassword123@@@'
        ]);

        // 檢查響應
        $response->assertStatus(401)
                    ->assertJson(['success' => false])
                    ->assertJsonStructure(['msg']);
    }

    public function test_logout_failure()
    {
       $token = 'wrongtoken'; //錯誤的令牌

       // 模擬登出請求，使用錯誤令牌在请求头
       $logoutResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token, // 加Bearer令牌
        ])->deleteJson('/api/sessions');

        // 檢查響應
        $logoutResponse->assertStatus(401)
                        ->assertJson(['success' => false])
                        ->assertJsonStructure(['msg']);
    }
}
