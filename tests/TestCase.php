<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function bootUp() {
        $this->artisan('db:wipe');
        $this->artisan('migrate');
        $this->artisan('db:seed --class="RoleSeeder"');
        $this->artisan('db:seed --class="User"');
    }

    protected function loginAsRole($role = '') {
        $loginApiLink = '/api/v1/users/login';

        // Only admin can create users

        if ($role === 'ADMIN') {
            // Login as Admin, PHP unit test case will take care of the
            // token/cookie
            $this->post($loginApiLink, [
                "username" => "admin",
                "password" => "admin@123",
            ]);
        }
        if ($role === 'PRODUCT_OWNER') {
            // Login as Admin, PHP unit test case will take care of the
            // token/cookie
            $this->post($loginApiLink, [
                "username" => "product_owner",
                "password" => "product_owner@123",
            ]);
        }

        if ($role === 'TEAM_MEMBER') {
            // Login as Admin, PHP unit test case will take care of the
            // token/cookie
            $this->post($loginApiLink, [
                "username" => "team",
                "password" => "team@123",
            ]);
        }
    }

    protected function shutdown() {
        $this->artisan('db:wipe');
    }
}
