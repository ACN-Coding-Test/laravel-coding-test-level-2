<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_assing_project_and_tasks_to_user()
    {
        $this->testInitiateAndClear();

        // ------------- product owner logging
        $authResponse = $this->testAuthLoginWithRole(Role::ROLE_TYPE_PRODUCT_OWNER);

        $authContentWithJason = json_decode($authResponse->getContent());
        // ------------- product owner logging

        // -------------- create a project
        $projectData = [
            "name" => "test1",
        ];

        $outDataProjectResponse = $this->post(
            '/api/v1/projects',
            $projectData,
            [
                'HTTP_Authorization' => 'Bearer ' . $authContentWithJason->jwt
            ]
        );

        $outDataProjectResponseJason = json_decode($outDataProjectResponse->getContent());
        // -------------- create a project

        // -------------- create a task and assing devs
        $taskData1 = [
            "title" => "title1",
            "description" => "description1",
            "project_id" => $outDataProjectResponseJason->id,
            "user_id" => 3
        ];

        $taskData2 = [
            "title" => "title2",
            "description" => "description2",
            "project_id" => $outDataProjectResponseJason->id,
            "user_id" => 4
        ];

        $outDataTaskResponse = $this->post(
            '/api/v1/tasks',
            $taskData1,
            [
                'HTTP_Authorization' => 'Bearer ' . $authContentWithJason->jwt
            ]
        );

        $outDataTaskResponse = $this->post(
            '/api/v1/tasks',
            $taskData2,
            [
                'HTTP_Authorization' => 'Bearer ' . $authContentWithJason->jwt
            ]
        );
        // -------------- create a task and assing devs

        $outDataTaskResponse->assertStatus(200);
    }
}
