<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_create()
    {
        $this->bootUp();
        $this->loginAsRole('ADMIN');

        $userData = [
            "name" => "Hiren Test",
            "email" => "hiren-test@atyantik.com",
            "username" => "hiren-test",
            "password" => "hiren-test@123",
            "password_confirmation" => "hiren-test@123",
            "role_id" => 1
        ];
        $createUserResponse = $this->post('/api/v1/users', $userData);
        $checkUserData = [
            "name" => "Hiren Test",
            "email" => "hiren-test@atyantik.com",
            "username" => "hiren-test",
            "role_id" => 1
        ];

        foreach ($checkUserData as $userKey => $userValue) {
            $createUserResponse->assertJsonPath("data.{$userKey}", $userValue);
        }
        $this->shutdown();
    }
}
