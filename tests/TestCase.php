<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    protected function testInit() {
        $this->artisan('db:wipe');
        $this->artisan('migrate');
        $this->artisan('db:seed --class="UserSeeder"');
    }
    
    protected function authLoginRole($role = '') {
        $loginApiLink = '/api/v1/login';
        $return = array();
        if ($role === 'admin') {
            $return = $this->post($loginApiLink, [
                "username" => "admin",
                "password" => "admin@123",
            ]);
        }
        if ($role === 'product_owner') {
            $return = $this->post($loginApiLink, [
                "username" => "product.owner",
                "password" => "productowner@123",
            ]);
        }
        if ($role === 'team_member') {
            $return = $this->post($loginApiLink, [
                "username" => "team.member.1",
                "password" => "teammember1@123",
            ]);
        }
        return $return;
    }

    protected function testClear() {
        $this->artisan('db:wipe');
    }
}
