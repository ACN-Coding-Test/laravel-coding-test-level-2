<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_users()
    {
        $admin = User::factory()->create(['role' => 'ADMIN', 'username' => 'mytest@username.com', 'password' => 'secret']);
        $response = $this->actingAs($admin)->post('api/v1/users', [
            'username' => 'my_username@test.com',
            'password' => 'secret',
        ]);

        $response->assertOk();

    }
}
