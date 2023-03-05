<?php
namespace App\Http\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can get all task.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function getAllTasks(User $user)
    {
        return (Role::ROLE_TYPE_PRODUCT_OWNER == $user->role_id) || (Role::ROLE_TYPE_DEVELOPER == $user->role_id);
    }

    /**
     * Determine whether the user can show task.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function showTask(User $user)
    {
        return (Role::ROLE_TYPE_PRODUCT_OWNER == $user->role_id) || (Role::ROLE_TYPE_DEVELOPER == $user->role_id);
    }

    /**
     * Determine whether the user can store the task.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function storeTask(User $user)
    {
        return Role::ROLE_TYPE_PRODUCT_OWNER == $user->role_id;
    }

        /**
     * Determine whether the user can update the task.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function updateTask(User $user)
    {
        return (Role::ROLE_TYPE_PRODUCT_OWNER == $user->role_id) || (Role::ROLE_TYPE_DEVELOPER == $user->role_id);
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function destroyTask(User $user)
    {
        return Role::ROLE_TYPE_PRODUCT_OWNER == $user->role_id;
    }

    /**
     * Determine whether the user can edit the task.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function editTask(User $user)
    {
        return (Role::ROLE_TYPE_PRODUCT_OWNER == $user->role_id) || (Role::ROLE_TYPE_DEVELOPER == $user->role_id);
    }
}