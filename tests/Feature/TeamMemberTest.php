<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamMemberTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_change_status()
    {
        $this->bootUp();
        // create project
        $this->loginAsRole('PRODUCT_OWNER');
        $project = [
            "name" => "Test Project A For Status Change",
        ];
        $createProjectResponse = $this->post('api/v1/projects', $project);
        $createProjectResponse->assertStatus(201);
        $createProjectResponse->assertJsonPath("data.name", "Test Project A For Status Change");
        $projectObj = json_decode($createProjectResponse->getContent());
        $existingTeamMember = \App\Models\User::where('email','team-member@atyantik.com')->first();

        $taskResponse = $this->post('api/v1/tasks', [
            "title" => "Task 1 For Status Change",
            "description" => "Task 1 For User 1",
            "project_id" => $projectObj->data->id,
            "user_id" => $existingTeamMember->id,
            "status" => 'NOT_STARTED'
        ]);
        $taskResponse->assertStatus(201);
        $taskObj = json_decode($taskResponse->getContent());

        $taskResponse->assertJsonPath("data.title", "Task 1 For Status Change");
        $taskResponse->assertJsonPath("data.status", 'NOT_STARTED');
        $taskResponse->assertJsonPath("data.project_id", $projectObj->data->id);
        $taskResponse->assertJsonPath("data.user_id", $existingTeamMember->id);

        $this->loginAsRole('TEAM_MEMBER');
        $taskResponse = $this->patch('api/v1/tasks/'.$taskObj->data->id, [
            "status" => 'IN_PROGRESS'
        ]);
        $taskResponse->assertStatus(200);

    }
}
