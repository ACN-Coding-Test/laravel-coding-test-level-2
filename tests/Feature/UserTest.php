<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\WithStubUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use WithStubUser;
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

    public function test_success_create_user()
    {
        $url = "http://laravel-coding.test/api/v1/register";
        $register = [
            'username' => 'shafizul123',
            'password' => 'testpass!',
            "password_confirmation" => "testpass!",
        ];

        $response = $this->post($url, $register);
        $response->assertStatus(201)
            ->assertJson(
                [
                    'status'    => 201,
                    'message'   => 'User Successfully Created',
                ]
            );
    }
}
