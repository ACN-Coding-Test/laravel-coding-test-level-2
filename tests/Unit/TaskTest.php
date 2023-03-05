<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskTest extends TestCase
{
    private $route = 'api/v1/tasks';
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testUnuthenticatedAccessTaskRoute()
    {
        $response = $this->json('post', $this->route);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testTeamMemberCanNotCreateTask()
    {
        $userToken = $this->generateToken('Team Member');

        $response = $this->json('post', $this->route, [], $this->generateHeader($userToken));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testValidationErrorWhileCreateingTask()
    {
        $userToken = $this->generateToken('Product Owner');
        $payload = [
            'title' => 'Create Test for this practical',
            'description' => 'Check your api is running properly or not',
            'project_id' => '',
        ];

        $this->json('post', $this->route, $payload, $this->generateHeader($userToken))
            ->assertStatus(419);
    }

    public function testTaskCreatedSuccessfully()
    {
        $userToken = $this->generateToken('Product Owner');

        $projectPayload = [
            'name' => 'New project for weekend',
        ];

        $project = $this->json('post', 'api/v1/projects', $projectPayload, $this->generateHeader($userToken));
        $project_id = json_decode($project->content(), true)['data']['id'];

        $users = $this->json('post', 'api/v1/free-users', [], $this->generateHeader($userToken));
        $user_id = collect(json_decode($users->content(), true)['data'])->inRandomOrder()->first()->id;

        $payload = [
            'title' => 'Create Test for this practical',
            'description' => 'Check your api is running properly or not',
            'project_id' => $project_id,
            'user_id' => $user_id
        ];

        $this->json('post', $this->route, $payload, $this->generateHeader($userToken))
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function testTeamMemberCanNotDeleteTask()
    {
        $userToken = $this->generateToken('Team Member');

        $response = $this->json('post', $this->route, [], $this->generateHeader($userToken));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
