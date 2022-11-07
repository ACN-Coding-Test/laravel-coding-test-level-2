<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class ProjectCreateAndAssignTest extends TestCase
{
    use DatabaseTransactions;
    private $user;

    public function setup() : void 
    {
        parent::setup();
        $this->user = User::factory()->create();
    }

    public function testProjectCreateAndAssignUserSuccess()
    {
        $this->actingAs($this->user, 'sanctum');

        $data = [
            'name'  => 'Financial Management System',
        ];

        $response = $this->post(route('project.store'), $data);
        
        $response->assertStatus(200)
            ->assertJson(
                [
                    'status'    => 200,
                    'message'   => 'Project Successfully Created',
                ]
            );

        $project_id = json_decode($response->getContent(), true)['data']['id'];
        $users = User::factory()->count(2)->create()->toArray();

        $task_data = [
            [
                'title'         => 'Develop payment module',
                'description'   => '',
                'project_id'    => $project_id,
                'user_id'       => $users[0]['id']
            ],
            [
                'title'         => 'Develop transaction module',
                'description'   => '',
                'project_id'    => $project_id,
                'user_id'       => $users[1]['id']
            ]
        ];

        for($i = 0; $i <= 1; $i++){
            
            $response = $this->post(route('task.store'), $task_data[$i]);
            
            $response->assertStatus(200)
                ->assertJson(
                    [
                        'status'    => 200,
                        'message'   => 'Task Successfully Created',
                    ]
                );

        }
    }
}
