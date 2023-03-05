<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_status_change()
    {
        $projectId = 0;
        $taskId = 0;

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

        $projectId = $outDataProjectResponseJason->id;
        // -------------- create a project

        // -------------- create a task and assing devs
        $taskData1 = [
            "title" => "title1",
            "description" => "description1",
            "project_id" => $projectId,
            "user_id" => 3
        ];

        $outDataTaskResponse = $this->post(
            '/api/v1/tasks',
            $taskData1,
            [
                'HTTP_Authorization' => 'Bearer ' . $authContentWithJason->jwt
            ]
        );

        $outDataTaskResponseJason = json_decode($outDataTaskResponse->getContent());

        $taskId = $outDataTaskResponseJason->id;
        // -------------- create a task and assing devs

        // ------------- logout the product ower
        $this->testAuthLogoutWithRole($authContentWithJason->jwt);
        // ------------- logout the product ower

        // ------------- dev logging
        $authDevResponse = $this->testAuthLoginWithRole(Role::ROLE_TYPE_DEVELOPER);

        $authDevContentWithJason = json_decode($authDevResponse->getContent());
        // ------------- dev logging

        // -------------- status change
        $taskData1 = [
            "title" => "title1",
            "description" => "description1",
            "project_id" => $projectId,
            "status" => Task::STATUS_TYPE_COMPLETED,
            "user_id" => 3
        ];

        $outDataTaskAssingResponse = $this->put(
            '/api/v1/tasks/' . $taskId,
            $taskData1,
            [
                'HTTP_Authorization' => 'Bearer ' . $authDevContentWithJason->jwt
            ]
        );
        // -------------- status change

        $outDataTaskAssingResponse->assertStatus(200);
    }
}
