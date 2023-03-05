<?php

namespace Tests;

use App\Models\Role;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function testInitiateAndClear() {
        $this->artisan('db:wipe');

        $this->artisan('migrate');

        $this->artisan('db:seed --class="RoleSeeder"');
        $this->artisan('db:seed --class="UserSeeder"');
    }

    protected function testAuthLoginWithRole(int $role) {
        $loginUrl = '/api/v1/login';

        $return = [];
        $userDetails = [];

        switch ($role) {
            case Role::ROLE_TYPE_ADMIN :
                $userDetails = [
                    'username' => 'admin',
                    'password' => '123456',
                ];
                break;

            case Role::ROLE_TYPE_PRODUCT_OWNER :
                $userDetails = [
                    'username' => 'po',
                    'password' => '123456',
                ];
                break;

            case Role::ROLE_TYPE_DEVELOPER :
                $userDetails = [
                    'username' => 'dev1',
                    'password' => '123456',
                ];
                break;

            default:
                break;
        }

        $return = $this->post($loginUrl, $userDetails);

        return $return;
    }

    protected function testAuthLogoutWithRole(string $token) {
        $outDataLogoutResponse = $this->post(
            '/api/v1/logout',
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . $token
            ]
        );
    }
}
