<?php
namespace App\Services\Roles;

use App\Constants\Permissions;
use App\Services\Roles\Contracts\RoleContract;

class Admin implements RoleContract
{
    public function label(): string
    {
        return 'Admin';
    }

    public function value(): string
    {
        return 'admin';
    }

    public function permissions(): array
    {
        return [
            Permissions::CREATE_USER,
            Permissions::VIEW_USER,
            Permissions::UPDATE_USER,
            Permissions::DELETE_USER,
        ];
    }
}
