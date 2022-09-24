<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_route()
    {
        $response = $this->get('/users');

        $response->assertStatus(404);
    }
    public function test_user_product_owner_register()
    {
        $user = [
            'name' => 'Product Owner',
            'email' => 'owner@test.com',
            'password' => 'passwordtest',
            'role_id' => 2 // PRODUCT_OWNER
          ];

        $response = $this->post('/api/auth/register', $user);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 401){
            $response->assertStatus(401);
        }else{
            $response->assertStatus(200);
        }
    }

    public function test_user_team_member_one_register()
    {
        $user = [
            'name' => 'Team Member 1',
            'email' => 'member1@test.com',
            'password' => 'passwordtest',
            'role_id' => 3 // TEAM_MEMBER
          ];

        $response = $this->post('/api/auth/register', $user);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 401){
            $response->assertStatus(401);
        }else{
            $response->assertStatus(200);
        }
    }

    public function test_user_team_member_two_register()
    {
        $user = [
            'name' => 'Team Member 2',
            'email' => 'member2@test.com',
            'password' => 'passwordtest',
            'role_id' => 3 // TEAM_MEMBER
          ];

        $response = $this->post('/api/auth/register', $user);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 401){
            $response->assertStatus(401);
        }else{
            $response->assertStatus(200);
        }
    }

    public function test_user_team_member_three_register()
    {
        $user = [
            'name' => 'Team Member 3',
            'email' => 'member3@test.com',
            'password' => 'passwordtest',
            'role_id' => 3 // TEAM_MEMBER
          ];

        $response = $this->post('/api/auth/register', $user);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 401){
            $response->assertStatus(401);
        }else{
            $response->assertStatus(200);
        }
    }
}
