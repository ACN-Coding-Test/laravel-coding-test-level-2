<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\Task;
use App\Models\Projects;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker;

    // public function __construct()
    // {
    //     $this->setUpFaker();
    // }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
    
    public function testCreateUser()
    {
        \Artisan::call('passport:install');

        $user = User::first();

        Passport::actingAs($user);

        $token = $user->testGenerateToken();

        $headers = [ 'Authorization' => 'Bearer $token'];
       
        $data = [
            'username' => $this->faker->unique()->name(),
            'password' => Hash::make("123"),
            'role_id' => Role::TEAM_MEMBER
        ];

        $response = $this->json('POST', '/api/v1/users',$data,$headers);
        
        $response->assertJson([]);

    }

    public function testCreateProject(){
        $user = User::where('role_id', Role::PRODUCT_OWNER)->first();

        Passport::actingAs($user);

        $token = $user->testGenerateToken();

        $headers = [ 'Authorization' => 'Bearer $token'];
       
        $data = [
            'name' => $this->faker->unique()->name(),
        ];

        $response = $this->json('POST', '/api/v1/project',$data,$headers);

        $response->assertJson([]);
    }

    public function testCreateTask(){
        $user_teammember = User::where('role_id', Role::TEAM_MEMBER)->inRandomOrder()->first();

        $project = Projects::inRandomOrder()->first();

        $user = User::where('role_id', Role::PRODUCT_OWNER)->inRandomOrder()->first();

        Passport::actingAs($user);

        $token = $user->testGenerateToken();

        $headers = [ 'Authorization' => 'Bearer $token'];
       
        $data = [
            'tittle' => $this->faker->text(10),
            'status' => 'NOT_STARTED',
            'project_id' => $project->id,
            'user_id' => $user_teammember->id,
            'description' => $this->faker->text(),
        ];

        $response = $this->json('POST', '/api/v1/task',$data,$headers);

        $response->assertJson([]);
    }

    public function testChangeTask(){
        $user_teammember = User::where('role_id', Role::TEAM_MEMBER)->whereHas('task_details')->first();

        $get_task = Task::where('user_id',$user_teammember->id)->inRandomOrder()->first();
        
        Passport::actingAs($user_teammember);

        $token = $user_teammember->testGenerateToken();

        $headers = [ 'Authorization' => 'Bearer $token'];
       
        $data = [
            'status' => 'IN_PROGRESS',
            'tittle' => $this->faker->text(10),
        ];

        $response = $this->json('PATCH', '/api/v1/task/'.$get_task->id,$data,$headers);

        $response->assertJson([]);
    }
}
