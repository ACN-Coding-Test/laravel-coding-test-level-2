<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AppControllerTest extends TestCase
{

    /**
     * @return mixed
     */
    protected function authentication($username)
    {
        Auth::guard('api')->attempt(["username" => $username, "password" => "password"]);
        return auth('api')->user()->createToken('token')->plainTextToken;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_users()
    {
        $response = $this->get('/api/v1/users');
        $response->assertStatus(200);
        $response->assertJson(json_decode($response->getContent(),true));
    }

    public function test_create_user()
    {
        $users = User::factory()->count(10)->create()->toArray();

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $this->authentication('admin')])
            ->post('/api/v1/users', $users);
        $response->assertStatus(200);

        $response = $this->getJson("/api/v1/users");
        $response->assertStatus(200);

        $response->assertJson(json_decode($response->getContent(),true));

    }

    public function test_create_project()
    {
        $users = User::factory()->count(10)->create()->toArray();

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' .  $this->authentication('admin')])
            ->post('/api/v1/users', $users);
        $response->assertStatus(200);

        //search users where role_id = 2
        $searchPM = 2;
        $foundPM = array_filter($users,function($v,$k) use ($searchPM){
            return $v['role_id'] == $searchPM;
        },ARRAY_FILTER_USE_BOTH);

        $searchDev = 3;
        $foundDev = array_filter($users,function($v,$k) use ($searchDev){
            return $v['role_id'] == $searchDev;
        },ARRAY_FILTER_USE_BOTH);

        //get first element
        $getPM = reset($foundPM);
        print_r($getPM);

        //generate auth token
        $token = $this->authentication($getPM['username']);
        print_r($token);

        //get developer
        $getDev = array_slice($foundDev, 0, 2);

        //start create project
        $project = [
            "name"=>"Kementerian Kerja Raya Website Upgrade"
        ];

        $resProject = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->post('/api/v1/projects', $project);
        //$resProject->assertStatus(200);

        dd('stuck here');

    }
}
