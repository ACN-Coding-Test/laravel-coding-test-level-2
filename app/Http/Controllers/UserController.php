<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('acl:list:users')->only(['index']);
        $this->middleware('acl:create:user')->only(['store']);
        $this->middleware('acl:view:user')->only(['show']);
        $this->middleware('acl:update:user')->only(['update']);
        $this->middleware('acl:delete:user')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        $user = app('user_manager')->store($request->input());

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request,  $userId)
    {
        $user = User::findOrFail($userId);
        $user = app('user_manager')->store($request->input(), $user);


        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }

    public function login(Request $request) {
        if(
            Auth::attempt([
                'username' => $request->username,
                'password' => $request->password
            ])
        ) {
            $role = Auth::user()->role->slug;
            $token = $request->user()->createToken($request->username, config("acl.{$role}") ?? []);
            return [
                'token' => $token->plainTextToken
            ];
        }
        throw new NotFoundHttpException('Cannot find user with provided details');
    }
}