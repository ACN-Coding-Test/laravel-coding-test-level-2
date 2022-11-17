<?php
namespace App\Dto;

class UpdateUserDto
{
    public function __construct(
        public ?string $username = null,
        public ?string $password = null,
        public ?string $role = null,
    ) {

    }

    public function toArray()
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'role' => $this->role
        ];
    }
}
