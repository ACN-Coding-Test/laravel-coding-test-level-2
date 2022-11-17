<?php
namespace App\Services\Roles;

use App\Constants\Permissions;
use App\Services\Roles\Contracts\RoleContract;

class ProductOwner implements RoleContract
{
    public function label(): string
    {
        return 'Product Owner';
    }

    public function value(): string
    {
        return 'product_owner';
    }

    public function permissions(): array
    {
        return [
            Permissions::CREATE_PROJECT,
            Permissions::VIEW_PROJECT,
            Permissions::UPDATE_PROJECT,
            Permissions::DELETE_PROJECT,
            Permissions::CREATE_TASK,
        ];
    }
}
