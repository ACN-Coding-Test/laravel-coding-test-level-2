<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_create()
    {
        $this->testInitiateAndClear();

        // ------------- admin logging
        $authResponse = $this->testAuthLoginWithRole(Role::ROLE_TYPE_ADMIN);

        $authContentWithJason = json_decode($authResponse->getContent());
        // ------------- admin logging

        $userData = [
            "username" => "test.admin",
            "password"=> "123456",
            "role_id" => Role::ROLE_TYPE_ADMIN,
            "password_confirmed"=> "123456",
        ];

        $outData = $this->post(
            '/api/v1/users',
            $userData,
            [
                'HTTP_Authorization' => 'Bearer ' . $authContentWithJason->jwt
            ]
        );

        $outData->assertStatus(200);
    }
}
