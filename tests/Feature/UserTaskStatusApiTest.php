<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTaskStatusApiTest extends TestCase
{
    public function test_change_status()
    {
        # Get Token User
        $tokenAdmin = $this->getToken('member');
        
        # Get Task Datas
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$tokenAdmin,
        ])->get('/api/v1/task');
        
        $getTasks = json_decode($response->content());
        
        foreach ($getTasks->data as $key => $value) {
            $postData = [
                "title" => $value->title,
                "description" => $value->description,
                "status_id" => 2
            ];
            $response = $this->withHeaders([
                'Authorization' => 'Bearer '.$tokenAdmin,
            ])->patch('/api/v1/task/'.$value->id,$postData);

            \Log::info($response->content());
        }
        $response->assertStatus(200);
    }


}
