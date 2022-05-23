<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_task()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('$3cr37')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];
        $task = \App\Models\Task::factory()->create([
            'title'=>'First TItile',
            'description'=>'First Description',
            'status' =>'NOT_STARTED'
        ]);

        $payload = [
            'title'=>'Second Title',
            'description'=>'Second Description',
            'status' =>'IN_PROGRESS'
        ];

        $response = $this->json('PUT', '/api/v1/updateStatus/' . $task->task_id, $payload, $headers)
            ->assertStatus(200);
    }
}
