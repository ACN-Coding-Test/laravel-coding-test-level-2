<?php
namespace App\Services\Roles;

use App\Services\Roles\Contracts\RoleContract;

class Developer implements RoleContract
{
    public function label(): string
    {
        return 'Dev';
    }

    public function value(): string
    {
        return 'dev';
    }

    public function permissions(): array
    {
        return [];
    }
}
