<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{

    public function test_can_change_task_status(){

        $test_task = Task::where('status', 'NOT_STARTED')->first();

        $test_product_owner= User::where('role', 'PRODUCT_OWNER')->first();

        $response = $this->actingAs($test_product_owner)->put(route('tasks.update', $test_task->id), [
            'title' => $test_task->title,
            'status' => 'IN_PROGRESS',
            'project_id' => $test_task->project_id,
            'user_id' => $test_task->user_id,
        ]);

        $response->assertOk();

    }
}
