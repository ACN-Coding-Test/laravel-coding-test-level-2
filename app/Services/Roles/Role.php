<?php
namespace App\Services\Roles;

use App\Services\Roles\Contracts\RoleContract;

class Role
{
    public array $roles;
    public array $rolesWithPermissions;

    public function addRole(RoleContract $role)
    {
        $this->roles[] = $role;
        $this->rolesWithPermissions[$role->value()] = $role->permissions();
        return $this;
    }

    public function options(): array
    {
        return collect($this->roles)->map(fn ($role) => [
            'label' => $role->label(),
            'value' => $role->value(),
        ])->toArray();
    }

    public function can($role, $permission): bool
    {
        return in_array($permission, $this->rolesWithPermissions[$role]);
    }
}
