<?php

namespace Tests\Unit;

use Illuminate\Http\Response;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    private $route = 'api/v1/projects';
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testUnuthenticatedAccessProjectRoute()
    {
        $response = $this->json('post', $this->route);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testTeamMemberCanNotCreateProject()
    {
        $userToken = $this->generateToken('Team Member');

        $response = $this->json('post', $this->route, [], $this->generateHeader($userToken));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testValidationErrorWhileCreateingProject()
    {
        $userToken = $this->generateToken('Product Owner');
        $payload = [
            'name' => '',
        ];

        $this->json('post', $this->route, $payload,$this->generateHeader($userToken))
            ->assertStatus(419);
    }

    public function testProjectCreatedSuccessfully()
    {
        $userToken = $this->generateToken('Product Owner');
        $payload = [
            'name' => 'New Practical Task project',
        ];

        $this->json('post', $this->route, $payload, $this->generateHeader($userToken))
            ->assertStatus(Response::HTTP_CREATED);
    }
}
