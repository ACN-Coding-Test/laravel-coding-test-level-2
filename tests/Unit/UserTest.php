<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Str;
//use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function testCreateResource()
    {
       $data = [
                        'username' => "Raja",
                        'password' => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
                        'role_id' => 1,
                        //'remember_token' => Str::random(10),
                    ];
            $user = \App\Models\User::factory()->count(3)->create();
            $response = $this->actingAs($user, 'api')->json('POST', '/api/v1/users',$data);
            $response->assertStatus(200);
            $response->assertJson(['status' => true]);
            $response->assertJson(['message' => "user Created!"]);
            $response->assertJson(['data' => $data]);
      }
}
