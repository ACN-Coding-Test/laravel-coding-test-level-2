<?php

namespace Tests;

use App\Models\User;

trait WithStubUser
{
    /**
     * @var \App\User
     */
    protected $user;

    public function createStubUser(array $data = [])
    {
        $data = array_merge([
            'username' => 'Test User',
            'password' => bcrypt('123456'),
        ], $data);

        return $this->user = User::create($data);
    }

    public function deleteStubUser()
    {
        $this->user->forceDelete();
    }
}