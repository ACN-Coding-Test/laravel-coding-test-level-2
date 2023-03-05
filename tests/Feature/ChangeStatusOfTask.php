<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Http\Response;
use Tests\TestCase;

class ChangeStatusOfTask extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testUnuthenticatedAccessProjectRoute()
    {
        $response = $this->json('post', 'api/v1/tasks/1/update-status');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testCanNotUpdateOthersTaskStatus()
    {
        $userToken = $this->generateToken('Team Member');
        $task = Task::where('user_id', '!=', auth()->user()->id)->where('status', 'NOT_STARTED')->first();
        $response = $this->json('post', `api/v1/tasks/$task->id/update-status`, [], $this->generateHeader($userToken));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testTaskStatusUpdatedSuccessfully()
    {
        $userToken = $this->generateToken('Team Member');
        $task = Task::where('user_id', auth()->user()->id)->where('status', 'NOT_STARTED')->first();

        $payload = [
            'status' => 'IN_PROGRESS'
        ];

        $response = $this->json('post', `api/v1/tasks/$task->id/update-status`, $payload, $this->generateHeader($userToken));
        $response->assertStatus(Response::HTTP_OK);
    }


}
