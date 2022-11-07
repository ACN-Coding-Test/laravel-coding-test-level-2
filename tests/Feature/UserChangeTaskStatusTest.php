<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class UserChangeTaskStatusTest extends TestCase
{
    use DatabaseTransactions;
    private $user;
    private $project;
    private $task;

    public function setup() : void 
    {
        parent::setup();
        $this->user     = User::factory()->create();
        $this->project  = Project::factory()->create();
        $this->task     = Task::factory()->create(['project_id' => $this->project->id, 'user_id' => $this->user->id]);
    }

    public function testUserChangeTaskStatusSuccess()
    {
        $this->actingAs($this->user, 'sanctum');

        $data = [
            'description'   => '',
            'status'        => 'COMPLETED'
        ];

        $response = $this->patch(route('task.update.status', $this->task['id']), $data);
        $response->assertStatus(200)
            ->assertJson(
                [
                    'status'    => 200,
                    'message'   => 'Task Successfully Updated',
                ]
            );
    }

    public function testUserChangeTaskStatusValidationFail()
    {
        $this->actingAs($this->user, 'sanctum');

        $data = [
            'description'   => '',
            'status'        => ''
        ];

        $expected_response = [
            "status" => [
                "The status field is required."
            ]
        ];

        $response = $this->patch(route('task.update.status', $this->task['id']), $data);
        $this->assertEquals($expected_response, json_decode($response->getContent(), true)['errors']);
    }
}
