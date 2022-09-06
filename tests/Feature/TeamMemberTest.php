<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TeamMemberTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_team_member_change_task_status()
    {
        $this->testInit();
            
            $this->authLoginRole('team_member');

            $updateResponse = $this->patch('api/v1/tasks/1', [
                "status" => 'in_progress'
            ]);
            $updateResponse->assertStatus(200);

        $this->testClear();
    }
}
