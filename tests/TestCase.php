<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getToken($role = '') {
        $loginApiLink = '/api/login';
        $return = array();
        if ($role === 'admin') {
            $return = $this->post($loginApiLink, [
                "username" => "admin",
                "password" => "123456",
            ]);
        }
        if ($role === 'product') {
            $return = $this->post($loginApiLink, [
                "username" => "product",
                "password" => "123456",
            ]);
        }
        if ($role === 'member') {
            $return = $this->post($loginApiLink, [
                "username" => "member",
                "password" => "123456",
            ]);
        }

        return json_decode($return->content())->access_token;
    }
}
