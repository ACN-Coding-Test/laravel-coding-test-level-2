<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    # Create Project
    public function test_create_project()
    {
        # Get Token User
        $token = $this->getToken('product');
        
        # Set Data
        $projectData = [
            "name" => "Test Unit Project",
        ];
        
        # Post Data
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            ])->post('/api/v1/project', $projectData);
            
        # Check Response
        $response->assertStatus(201);
    }
}
