<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_project_request()
    {
    $this
        ->actingAs(\App\Models\User::factory()->count(1)->create())
        ->json('POST', '/api/v1/projects', [
          'name' => 'Lorem'
        ])
        ->assertStatus(200)
        ->assertJson(['created'=>true]);
    }
}
