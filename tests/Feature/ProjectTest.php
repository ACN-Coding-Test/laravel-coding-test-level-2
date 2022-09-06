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
    public function test_example()
        {
            $response = $this->get('/');

            $response->assertStatus(200);
        }

    public function test_create_project()
        {
            $this->testInit();
            //login as product owner and create project
            $this->authLoginRole('product_owner');
            $project = [
                "name" => "Test Project 1",
            ];
            $createProjectResponse = $this->post('/api/v1/projects', $project);
            $createProjectResponse->assertStatus(201);
            $createProjectResponse->assertJsonPath("data.name", "Test Project 1");
            $projectObj = json_decode($createProjectResponse->getContent());
            $teamMember1Id = 3;$teamMember2Id = 4;    
            $taskData1 = [
                "title" => "Test Task 1",
                "description" => "description 1=> test Task For User",
                "project_id" => $projectObj->data->id,
                "user_id" => $teamMember1Id,
                "status" => 'not_started'
            ];
            $createTaskResponse1 = $this->post('/api/v1/tasks', $taskData1);
            $createTaskResponse1->assertStatus(201);
            $createTaskResponse1->assertJsonPath("data.title", "Test Task 1");
            $createTaskResponse1->assertJsonPath("data.status", 'not_started');
            $createTaskResponse1->assertJsonPath("data.project_id", $projectObj->data->id);
            $createTaskResponse1->assertJsonPath("data.user_id", $teamMember1Id);

            $taskData2 = [
                "title" => "Test Task 2",
                "description" => "description 2=> test Task For User",
                "project_id" => $projectObj->data->id,
                "user_id" => $teamMember2Id,
                "status" => 'not_started'
            ];
            $createTaskResponse2 = $this->post('/api/v1/tasks', $taskData2);
            $createTaskResponse2->assertStatus(201);
            $createTaskResponse2->assertJsonPath("data.title", "Test Task 2");
            $createTaskResponse2->assertJsonPath("data.status", 'not_started');
            $createTaskResponse2->assertJsonPath("data.project_id", $projectObj->data->id);
            $createTaskResponse2->assertJsonPath("data.user_id", $teamMember2Id);


            $this->testClear();
        }

}
