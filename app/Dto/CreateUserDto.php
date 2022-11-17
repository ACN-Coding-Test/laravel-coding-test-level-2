<?php
namespace App\Dto;

class CreateUserDto
{
    public function __construct(
        public string $username,
        public string $password,
        public string $role,
    ) {

    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'role' => $this->role,
        ];
    }
}
