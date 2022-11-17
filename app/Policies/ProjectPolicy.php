<?php

namespace App\Policies;

use App\Constants\Permissions;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return app('roleService')->can($user->role, Permissions::CREATE_PROJECT);
    }

    public function view(User $user)
    {
        return app('roleService')->can($user->role, Permissions::VIEW_PROJECT);
    }

    public function update(User $user)
    {
        return app('roleService')->can($user->role, Permissions::UPDATE_PROJECT);
    }

    public function delete(User $user)
    {
        return app('roleService')->can($user->role, Permissions::DELETE_PROJECT);
    }
}
