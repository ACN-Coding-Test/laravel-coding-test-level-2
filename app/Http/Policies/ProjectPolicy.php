<?php
namespace App\Http\Policies;

use App\Models\Role;
use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can get all products.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function getAllProjects(User $user)
    {
        return Role::ROLE_TYPE_PRODUCT_OWNER == $user->role_id;
    }

    /**
     * Determine whether the user can show project.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function showProject(User $user)
    {
        return Role::ROLE_TYPE_PRODUCT_OWNER == $user->role_id;
    }

    /**
     * Determine whether the user can store the project.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function storeProject(User $user)
    {
        return Role::ROLE_TYPE_PRODUCT_OWNER == $user->role_id;
    }

        /**
     * Determine whether the user can update the project.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function updateProject(User $user)
    {
        return Role::ROLE_TYPE_PRODUCT_OWNER == $user->role_id;
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function destroyProject(User $user)
    {
        return Role::ROLE_TYPE_PRODUCT_OWNER == $user->role_id;
    }

    /**
     * Determine whether the user can edit the project.
     *
     * @param User $user
     * 
     * @return mixed
     */
    public function editProject(User $user)
    {
        return Role::ROLE_TYPE_PRODUCT_OWNER == $user->role_id;
    }
}