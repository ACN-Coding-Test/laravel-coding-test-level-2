<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_user()
    {
        $response = $this->postJson('/api/v1/register', [
            'username' => "Khalid1",
            'password' => "P@ssword1",
            'password_confirmation' => "P@ssword1",
            'role_id' => '1'
        ]);
            

        $response
            ->assertStatus(201);
    }
}
