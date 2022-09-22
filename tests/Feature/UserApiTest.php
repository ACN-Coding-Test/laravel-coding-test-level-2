<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    # Create User
    public function test_create_user()
    {

        # Get Token User
        $token = $this->getToken('admin');

        # Set Data
        $userData['data'] = [
            [ 
                "name" => "User Testing",
                "username" => "testunit1",
                "password"=> "123456",
                "role_id"=> 1
            ],[
                "name" => "User Testing 2",
                "username" => "testunit2",
                "password"=> "123456",
                "role_id"=> 1
            ]
        ];
        
        // # Post Data
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->post('/api/v1/user', $userData);

        # Check Response
        $response->assertStatus(201);
        
    }
}
