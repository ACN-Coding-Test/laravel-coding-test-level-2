<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {

        $this->artisan('db:wipe');
        $this->artisan('migrate');
        $this->artisan('db:seed');

        $response = $this->get('api');
        $response->assertStatus(200);
    }
}
