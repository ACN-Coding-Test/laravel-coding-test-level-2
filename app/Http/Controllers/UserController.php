<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::get();

        return new UserCollection($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedArray = $request->all();

        $validator = Validator::make($validatedArray, [
            'username' => 'required|unique:users|max:255',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $returnMessage['status'] = 'error';
            $returnMessage['message'] = $validator->errors()->first();
            return response()->json($returnMessage, 422);
        }

        $user = new User;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'User created successfully.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $validatedArray = $request->all();

        $validator = Validator::make($validatedArray, [
            'username' => 'max:255',
            'password' => '',
        ]);

        if ($validator->fails()) {
            $returnMessage['status'] = 'error';
            $returnMessage['message'] = $validator->errors()->first();
            return response()->json($returnMessage, 422);
        }

        if (!empty($request->username)) {
            $user->username = $request->username;
        }

        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json(['status' => 'success', 'message' => 'User updated successfully.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete();

        return response()->json(['status' => 'success', 'message' => 'User deleted successfully.'], 201);
    }
}
