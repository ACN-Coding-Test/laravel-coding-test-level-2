<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_project()
    {
        $this->bootUp();
        // create two user
        $this->loginAsRole('ADMIN');
        $user1Data=[
                "name" => "Demo User 1",
                "email" => "demo-1@atyantik.com",
                "username" => "demo-1",
                "password" => "demo-1@123",
                "password_confirmation" => "demo-1@123",
                "role_id" => 3
            ];
        $user2Data=[
                "name" => "Demo User 2",
                "email" => "demo-2@atyantik.com",
                "username" => "demo-2",
                "password" => "demo-2@123",
                "password_confirmation" => "demo-2@123",
                "role_id" => 3
            ];
        $createUser1Response = $this->post('/api/v1/users', $user1Data);
        $createUser2Response = $this->post('/api/v1/users', $user2Data);
        $createUser1Response->assertStatus(201);
        $createUser2Response->assertStatus(201);
        $user1 = json_decode($createUser1Response->getContent());
        $user2 = json_decode($createUser2Response->getContent());

        // create project
        $this->loginAsRole('PRODUCT_OWNER');
        $project = [
            "name" => "Test Project A",
        ];
        $createProjectResponse = $this->post('api/v1/projects', $project);
        $createProjectResponse->assertStatus(201);
        $createProjectResponse->assertJsonPath("data.name", "Test Project A");
        $projectObj = json_decode($createProjectResponse->getContent());

        $task1Response = $this->post('api/v1/tasks', [
            "title" => "Task 1",
            "description" => "Task 1 For User 1",
            "project_id" => $projectObj->data->id,
            "user_id" => $user1->data->id,
            "status" => 'NOT_STARTED'
        ]);
        $task1Response->assertStatus(201);
        $task1Response->assertJsonPath("data.title", "Task 1");
        $task1Response->assertJsonPath("data.status", 'NOT_STARTED');
        $task1Response->assertJsonPath("data.project_id", $projectObj->data->id);
        $task1Response->assertJsonPath("data.user_id", $user1->data->id);
        
        $task2Response = $this->post('/api/v1/tasks', [
            "title" => "Task 2",
            "description" => "Task 2 for user 2",
            "project_id" => $projectObj->data->id,
            "user_id" => $user2->data->id,
            "status" => 'NOT_STARTED'
        ]);
        $task2Response->assertStatus(201);
        $task2Response->assertJsonPath("data.title", "Task 2");
        $task2Response->assertJsonPath("data.status", 'NOT_STARTED');
        $task2Response->assertJsonPath("data.project_id", $projectObj->data->id);
        $task2Response->assertJsonPath("data.user_id", $user2->data->id);

        $this->shutdown();
    }
}
