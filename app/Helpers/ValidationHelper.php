<?php

namespace App\Helpers;

class ValidationHelper
{
    public static function getLoginRules()
    {
        return [
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ];
    }

    public static function getUserDetailsRules()
    {
        return [
            'id' => 'required|uuid'
        ];
    }

    public static function getCreateUserRules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable',
            'name' => 'required|string'
        ];
    }

    public static function getUpdateUserRules()
    {
        return [
            'id' => 'required|exists:users,id',
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string'
        ];
    }
}