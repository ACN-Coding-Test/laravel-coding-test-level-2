<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTaskApiTest extends TestCase
{
   # Create Task
   public function test_create_task()
   {
       # Get Token User
       $tokenAdmin = $this->getToken('admin');
       
       # Get Users Data 
       $response = $this->withHeaders([
               'Authorization' => 'Bearer '.$tokenAdmin,
           ])->get('/api/v1/user');
       
       $getUsers = json_decode($response->content());

       # Collect 2 users
       \Log::info('api user: '.json_encode($getUsers->data));

       $userList = [];
       foreach ($getUsers->data as $key => $value) {
           if ($value->role_id == 1) {
               $userList[] = $value->id;
           }
           if (count($userList) == 2) {
               break;
           }
       }
       \Log::info('Users: '.json_encode($userList));

        # Get Project Id
        $responseProject = $this->withHeaders([
            'Authorization' => 'Bearer '.$tokenAdmin,
        ])->getJson('/api/v1/project',["q" => "Test Unit Project"]);

        $getProject = json_decode($responseProject->content());
        $projectId = $getProject->data[0]->id;
        \Log::info('Project id: '.$projectId);

        # Create Task
        if ($userList) {
            # Get Token User
            $tokenProduct = $this->getToken('product');
            
            # Set Data
            $projectData = [
                [
                    "title" => "First Task",
                    "description" => "This is First Task",
                    "project_id" => $projectId
                ],[
                    "title" => "Second Task",
                    "description" => "This is Second Task",
                    "project_id" => $projectId
                ]
            ];
            
            # Post Data
            foreach ($userList as $key => $value) {
                $projectData[$key]['user_id'] = $value;
                $response = $this->withHeaders([
                    'Authorization' => 'Bearer '.$tokenProduct,
                ])->post('/api/v1/task', $projectData[$key]);
            }
            # Check Response
            $response->assertStatus(201);
        }
   }
}
