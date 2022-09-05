<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $users = User::all();
        return response()->json($users);

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $user = User::with(['products','tasks'])->find($id);

        return response()->json($user);
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(UserRequest $request): JsonResponse
    {
        $this->authorize('create-delete-users');
        try {

            $user = new User();
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->role_id = isset($request->role_id) && $request->role_id != '' ? $request->role_id: 3;
            $user->save();

        } catch (Throwable $throwable) {

            return response()->json([
                "status" => "error",
                "message" => $throwable->getMessage()
            ], 500);

        }

        return response()->json([
            "status" => "success",
            "message" => "Successfully created user",
            "data"=>$user
        ]);
    }

    /**
     * @param $id
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function update($id, UserRequest $request): JsonResponse
    {
        try {
            $user = User::find($id);

            if ($request->method() == 'PATCH') {

                $user->update($request->only('role_id'));

            } else {
                $user->username = isset($request->username) && $request->username != '' ? $request->username : $user->username;
                $user->password = bcrypt($request->password);
                $user->role_id = isset($request->role_id) && $request->role_id != ''  ? $request->role_id : $user->role_id;
                $user->save();
            }



        } catch (Throwable $throwable) {

            return response()->json([
                "status" => "error",
                "message" => $throwable->getMessage()
            ], 500);

        }

        return response()->json([
            "status" => "success",
            "message" => "Successfully updated user",
            "data" => $user
        ]);

    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        $this->authorize('create-delete-users');
        try {

            User::find($id)->delete();

        } catch (Throwable $throwable) {

            return response()->json([
                "status" => "Error",
                "message" => $throwable->getMessage()
            ], 500);

        }

        return response()->json([
            "status" => "success",
            "message" => "Successfully destroyed user"
        ]);
    }

}
