<?php

namespace Tests;

use App\Models\User;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    private Generator $faker;

    private $loginURL = '/api/v1/login';

    public function setUp(): void
    {
        parent::setUp();

        User::factory(1)->create([
            'name' => 'Admin User',
            'username' => 'admin.user',
            'password' => Hash::make('12345678'),
        ])->each(function ($user) {
            $user->assignRole('Admin');
        });

        User::factory(1)->create([
            'name' => 'Product User',
            'username' => 'product.user',
            'password' => Hash::make('12345678')
        ])->each(function ($user) {
            $user->assignRole('Product Owner');
        });

        User::factory(1)->create([
            'name' => 'Team Member User',
            'username' => 'member.user',
            'password' => Hash::make('12345678'),
        ])->each(function ($user) {
            $user->assignRole('Team Member');
        });

        Artisan::call('db:seed');
    }

    /**
     * Generate a token based on user role
     *
     * @param string $role
     * @return void
     */
    protected function generateToken($role)
    {
        if ($role === 'Admin') {
            $request = $this->json('post', $this->loginURL, [
                "username" => "admin.user",
                "password" => "12345678",
            ]);
        }
        elseif ($role === 'Product Owner') {
            $request = $this->json('post', $this->loginURL, [
                "username" => "product.user",
                "password" => "12345678",
            ]);
        }
        elseif ($role === 'Team Member') {
            $request = $this->json('post', $this->loginURL, [
                "username" => "member.user",
                "password" => "12345678",
            ]);
        }
        $response = json_decode($request->content(), true);
        return $response['data']['token'];
    }

    protected function generateHeader($token){
        return [
            'Authorization' => 'Bearer ' . $token,
        ];
    }
}
