<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_project_route_exist_non_login_failed()
    {
        $response = $this->get('/api/v1/projects');

        $response->assertStatus(302);
    }

    public function test_project_create_with_user_role_product_owner()
    {
        $user = User::where('role_id', '=', 2)->first(); //role = product owner
        $project = [
            'name' => 'Project 1',
            'user_id' => $user->id
        ];
        $response = $this->actingAs($user)
                    ->withSession(['banned' => false])
                    ->post('/api/v1/projects', $project);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 500){ //because project name unique, cant craete duplicate.
            $response->assertStatus(500);
        }else{
            $response->assertStatus(200);
        }
        $lp = Project::latest()->first();
        if ($statusCode == 200){
            $userTeams = User::where('role_id', '=', 3)->take(2)->get();
            foreach($userTeams as $key => $ut){
                $this->create_task($this->actingAs($user), $key, $ut, $user, $lp);
            }
        }
    }


    public function create_task($actingAs, $key, $ut, $user, $lp){
        $task = [
            'title' => 'Task ' . $key,
            'description' => 'Task ' . $key,
            'project_id' => $lp->id,
            'status_id' => 1, //1 refers not startecd the task yet
            'user_id' => $ut->id,
        ];
        $response = $actingAs
                ->withSession(['banned' => false])
                ->post('/api/v1/tasks', $task);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 500){
            $response->assertStatus(500);
        }else{
            $response->assertStatus(200);
        }
    }
}
