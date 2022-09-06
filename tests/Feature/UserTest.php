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
        $this->testInit();
        $this->authLoginRole('admin');
        $userData = [
            "username" => "arjun.solanki",
            "password"=> "arjun@123",
            "role"=>"team_member",
        ];
        $createUserResponse = $this->post('/api/v1/users', $userData);
        $checkUserData = [
            "username" => "arjun.solanki",
            "role"=>"team_member",
        ];
        foreach ($checkUserData as $userKey => $userValue) {
            $createUserResponse->assertJsonPath("data.{$userKey}", $userValue);
        }
        $this->testClear();
    }
}
