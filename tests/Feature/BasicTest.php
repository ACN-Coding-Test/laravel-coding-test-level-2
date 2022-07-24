<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\Task;

class BasicTest extends TestCase
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
    
    public function test_create_user()
    {
        //have to login role admin to be able to use api create user
        $response = $this->postJson('/api/login', [
            'email' => 'anis@gmail.com',
            'password' => 'P@ssw0rd',
        ]);
        $response->assertStatus(200);

        $response2 = $this->post('/api/user', [
            'name' => 'Testing 1',
            'email' => 'hihi@gmail.com',
            'password' => Hash::make('Testing'),
            'role' => 1,
        ], ['HTTP_Authorization' => 'Bearer' . $response['data']['access_token']]);
        $response2->assertStatus(200);
    }

    public function test_create_project()
    {
        // login product owner
        $response = $this->postJson('/api/login', [
            'email' => 'cuba@gmail.com',
            'password' => 'P@ssw0rd',
        ]);
        $response->assertStatus(200);

        // create a project
        $response2 = $this->post('/api/project', [
            'name' => 'PNB Project',
        ], ['HTTP_Authorization' => 'Bearer' . $response['data']['access_token']]);
        $response2->assertStatus(200);

        // get id project
        $response3 = $this->get('/api/project', [
            'q' => 'PNB Project',
        ], ['HTTP_Authorization' => 'Bearer' . $response['data']['access_token']]);
        $response3->assertStatus(200);

        // create a project task to user 1
        $response4 = $this->post('/api/task', [
            'title'=> 'Collect Requirement',
            'description'=> 'meeting with client',
            'status'=> Task::NOT_STARTED,
            'project_id'=> $response3['data']['data'][0]['id'],
            'user_id' => 3,
        ], ['HTTP_Authorization' => 'Bearer' . $response['data']['access_token']]);
        $response4->assertStatus(200);

        // create a project task to user 2
        $response4 = $this->post('/api/task', [
            'title'=> 'Design the Interface',
            'description'=> null,
            'status'=> Task::NOT_STARTED,
            'project_id'=> $response3['data']['data'][0]['id'],
            'user_id' => 4,
        ], ['HTTP_Authorization' => 'Bearer' . $response['data']['access_token']]);
        $response4->assertStatus(200);
        
    }

    public function test_change_status(){
         // team member login
         $response = $this->postJson('/api/login', [
            'email' => 'try@gmail.com',
            'password' => 'P@ssw0rd',
        ]);
        $response->assertStatus(200);

        // change task status user 1
        $response4 = $this->patch('/api/task/status/5', [
            'status'=> Task::IN_PROGRESS,
        ], ['HTTP_Authorization' => 'Bearer' . $response['data']['access_token']]);
        $response4->assertStatus(200);
    }

}
