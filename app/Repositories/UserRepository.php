<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\User;
use App\Interfaces\CrudInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Pagination\Paginator;

class UserRepository implements CrudInterface
{
    /**
     * Authenticated User Instance.
     *
     * @var User
     */
    public User $user;

    public function __construct()
    {
        // $this->user = Auth::guard()->user();
    }

    /**
     * Get All Users.
     *
     * @return collections Array of User Collection
     */
    public function getAll(): Paginator
    {
        return User::orderBy('id', 'desc')
            ->paginate(10);
    }


    /**
     * Get Paginated User Data.
     *
     * @param int $pageNo
     * @return collections Array of User Collection
     */
    public function getPaginatedData($perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 12;
        return User::orderBy('id', 'desc')
            ->with('user')
            ->paginate($perPage);
    }

    /**
     * Create New User.
     *
     * @param array $data
     * @return object User Object
     */
    public function create(array $data): User
    {

        $data = [
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password'])
        ];

        return User::create($data);
    }

    /**
     * Delete User.
     *
     * @param int $id
     * @return boolean true if deleted otherwise false
     */
    public function delete(int $id): bool
    {
        $user = User::find($id);
        if (empty($user)) {
            return false;
        }
        $user->delete($user);
        return true;
    }

    /**
     * Get User Detail By ID.
     *
     * @param int $id
     * @return void
     */
    public function getByID(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * Update User By ID.
     *
     * @param int $id
     * @param array $data
     * @return object Updated User Object
     */
    public function update(int $id, array $data): User
    {
        $user = User::find($id);
        if (!empty($data['image'])) {
            $titleShort = Str::slug(substr($data['title'], 0, 20));
            $data['image'] = UploadHelper::update('image', $data['image'], $titleShort . '-' . time(), 'images/users', $user->image);
        } else {
            $data['image'] = $user->image;
        }

        if (is_null($user)) {
            return null;
        }

        // If everything is OK, then update.
        $user->update($data);

        // Finally return the updated user.
        return $this->getByID($user->id);
    }



    public function register(array $data): User
    {
        $data = [
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password'])
        ];

        return User::create($data);
    }
}