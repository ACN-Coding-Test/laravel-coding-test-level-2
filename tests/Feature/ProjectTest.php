<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_project_and_assign_two_users()
    {

        $user1 = User::factory()->create(['role' => 'PRODUCT_OWNER', 'username' => 'mytest@username.com', 'password' => 'secret']);
        $user2 = User::factory()->create(['role' => 'PRODUCT_OWNER', 'username' => 'mytest2@username.com', 'password' => 'secret']);


        $project = $this->actingAs($user1)->post('api/v1/projects', [
            'name' => 'My first Project',
        ]);

        $response = $this->actingAs($user1)->post('api/v1/tasks', [
            'title' => 'Title of the Task',
            'description' => 'Test description of Task',
            'project_id' => $project['id'],
            'user_id' => $user1->id,
        ]);

        $response2 = $this->actingAs($user2)->post('api/v1/tasks', [
            'title' => 'Title of the Task',
            'description' => 'Test description of Task',
            'project_id' => $project['id'],
            'user_id' => $user2->id,
        ]);

        $response->assertStatus(201);
    }
}
