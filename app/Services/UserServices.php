<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\User;

class UserServices
{
    public function getUsers()
    {
        try {
            $users = User::all();
            return $users;
        } catch (\Exception $e) {
            Log::error('(Error) Retrieve users failed. Error: ' . PHP_EOL . $e->getMessage());
            throw new \Exception('Login failed.');
        }
    }

    public function getUser($id)
    {
        try {
            $user = User::find($id);
            return $user;
        } catch (\Exception $e) {
            Log::error('(Error) Retrieve users failed. Error: ' . PHP_EOL . $e->getMessage());
            throw new \Exception('Retrieve users failed.');
        }
    }

    public function createUser($input)
    {
        try {
            DB::beginTransaction();

            $uuid = (string) Str::uuid();
            $user = User::create(
                [
                    'id' => $uuid,
                    'email' => $input['email'],
                    'name' => $input['name'],
                    'password' => empty($input['password']) ? null : bcrypt($input['password'])
                ]
            );

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('(Error) Create user failed. Error: ' . PHP_EOL . $e->getMessage());
            throw new \Exception('Create user failed.');
        }
    }

    public function updateUser($input)
    {
        try {
            DB::beginTransaction();

            $user = User::find($input['id']);
            $user->update(
                Arr::only($input, app(User::class)->getFillable())
            );

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('(Error) Update user failed. Error: ' . PHP_EOL . $e->getMessage());
            throw new \Exception('Update user failed.');
        }
    }

    public function deleteUser($id)
    {
        try {
            DB::beginTransaction();

            $user = User::find($id);
            $user->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('(Error) Delete user failed. Error: ' . PHP_EOL . $e->getMessage());
            throw new \Exception('Delete user failed.');
        }
    }
}
