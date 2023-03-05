<?php
namespace App\Http\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can get all users.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function getAllUsers(User $user)
    {
        return Role::ROLE_TYPE_ADMIN == $user->role_id;
    }

    /**
     * Determine whether the user can show user.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function showUser(User $user)
    {
        return Role::ROLE_TYPE_ADMIN == $user->role_id;
    }

    /**
     * Determine whether the user can store user.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function storeUser(User $user)
    {
        return Role::ROLE_TYPE_ADMIN == $user->role_id;
    }

    /**
     * Determine whether the user can update user.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function updateUser(User $user)
    {
        return Role::ROLE_TYPE_ADMIN == $user->role_id;
    }

    /**
     * Determine whether the user can delete user.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function destroyUser(User $user)
    {
        return Role::ROLE_TYPE_ADMIN == $user->role_id;
    }

    /**
     * Determine whether the user can edit user.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function editUser(User $user)
    {
        return Role::ROLE_TYPE_ADMIN == $user->role_id;
    }
}