<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        return User::all();
    }

    public function show(string $id)
    {
        return User::where('id', $id)->first();
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required',
        ]);
        $user = User::create([
            'id' => (string)  Str::uuid(),
            'username' => $request->username ?? 'abu',
            'password' => Hash::make($request->password),

        ]);

        if ($user) {
            return ['success' => true];
        }

        return ['error' => true];
    }

    public function update(Request $request, string $id)
    {
        if (User::where('id', $id)->update(['username' => $request->username])) {
            return ['success' => true];
        }

        return ['error' => true];
    }

    public function destroy(string $id)
    {
        if (User::where('id', $id)->delete()) {
            return ['success' => true];
        }

        return ['error' => true];
    }
}
