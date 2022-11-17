<?php

namespace App\Policies;

use App\Constants\Permissions;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return app('roleService')->can($user->role, Permissions::CREATE_USER);
    }

    public function update(User $user)
    {
        return app('roleService')->can($user->role, Permissions::UPDATE_USER);
    }

    public function delete(User $user)
    {
        return app('roleService')->can($user->role, Permissions::DELETE_USER);
    }

    public function view(User $user)
    {
        return app('roleService')->can($user->role, Permissions::VIEW_USER);
    }
}
