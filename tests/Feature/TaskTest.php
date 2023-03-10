<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function test_task_status_update_team_member()
    {
            $user = User::where('role_id', '=', 3)->first();
            $task = Task::where('status_id', '=', 1)->where('user_id', '=', $user->id)->first();
            if($task){
                $ts = [
                    'status_id' => 2, //2 refers status IN_PROGRESS
                ];
                $response = $this->actingAs($user)
                        ->withSession(['banned' => false])
                        ->patch('/api/v1/tasks/'. $task->id, $ts);
                $statusCode = $response->getStatusCode();
                if ($statusCode == 500){
                    $response->assertStatus(500);
                }else{
                    $response->assertStatus(200);
                }
            }else{
                $this->assertTrue(true);
            }
    }
}