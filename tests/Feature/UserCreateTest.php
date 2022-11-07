<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCreateTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserCreateSuccess()
    {
        $data = [
            'username'  => 'Siti Nasuha',
            'password'  => Hash::make('nasuha2022'),
            'role'      => 'ADMIN'
        ];

        $response = $this->post(route('register'), $data);
        
        $response->assertStatus(200)
            ->assertJson(
                [
                    'status'    => 200,
                    'message'   => 'User Successfully Created',
                ]
            );
    }

    public function testUserCreateValidationFail()
    {
        $data = [
            'username'  => '',
            'password'  => 'Siti',
            'role'      => null
        ];

        $expected_response = [
            "username" => [
                "The username field is required."
            ],
            "password" => [
                "The password must be at least 6 characters."
            ],
            "role" => [
                "The role field is required."
            ]
        ];

        $response = $this->post(route('register'), $data);
        $this->assertEquals($expected_response, json_decode($response->getContent(), true)['errors']);
    }
}
