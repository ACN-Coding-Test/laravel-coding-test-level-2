<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $route = 'api/v1/users';
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testUnuthenticatedAccessUserRoute()
    {
        $response = $this->json('post', $this->route);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUnuthorizedAccessUserRoute()
    {
        $productUserToken = $this->generateToken('Product Owner');

        $response = $this->json('post', $this->route,[], $this->generateHeader($productUserToken));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testValidationErrorWhileCreateUser()
    {
        $adminUserToken = $this->generateToken('Admin');
        $payload = [
            'name' => '',
            'username' => 'apurv.testuser',
            'password' => Hash::make('12345678'),
        ];

        $this->json('post', $this->route, $payload,$this->generateHeader($adminUserToken))
            ->assertStatus(419);
    }

    public function testUserCreatedSuccessfully()
    {
        $adminUserToken = $this->generateToken('Admin');
        $payload = [
            'name' => 'Apurv Bhavsar',
            'username' => 'apurv.testuser',
            'password' => Hash::make('12345678'),
        ];

        $this->json('post', $this->route, $payload, $this->generateHeader($adminUserToken))
            ->assertStatus(Response::HTTP_CREATED);
    }
}
