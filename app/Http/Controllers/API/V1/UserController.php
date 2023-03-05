<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return $this->success($users, 'User list', 200);
    }

    public function store(CreateRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username'  => $request->username,
            'password'  => Hash::make($request->password),
        ]);

        $user->assignRole($request->role ?? 'Admin');
        // Can notify user for his accoun is created

        return $this->success($user, 'User has been created', 201);
    }

    public function show(User $user)
    {
        return $this->success($user, 'User detail', 200);
    }

    public function update(UpdateRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->username = $request->username;

        $user->syncRoles($request->role);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        } else {
            $user->save();
        }

        return $this->success($user, 'User Successfully Updated', 200);
    }

    public function destroy(User $user)
    {
        if($user->delete()){
            return $this->success($user, 'User Successfully Deleted', 200);
        }

        return $this->error('Something went wrong');
    }

    public function freeUsers()
    {
        $taskUserID = Task::where('status', '!=', 'COMPLETED')->get()->pluck('user_id');

        $users = User::role('Team Member')->whereNotIn('id', $taskUserID)->get();

        return $this->success($users, 'User list who available', 200);
    }
}
