<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Auth;
use DB;

class UserController extends Controller
{
    public function index()
    {
        try {

            if(getRole() != 'ADMIN'){
                return response()->json([
                    'status' => 401,
                    'message' => 'you do not have permission to access this API',
                ], 401);
            }
            
            $users = User::all();

            return response()->json([
                'status' => 200,
                'message' => 'User List Successfully Retrieved',
                'data' => $users->toArray()
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        $roles = ['ADMIN', 'PRODUCT_OWNER', 'MEMBER'];

        try {

            if(in_array($request->role, $roles) == false){
                return response()->json([
                    'status' => 401,
                    'message' => 'Only ADMIN, PRODUCT_OWNER and MEMBER role are allowed',
                ], 401);
            }

            if(getRole() != 'ADMIN'){
                return response()->json([
                    'status' => 401,
                    'message' => 'you do not have permission to access this API',
                ], 401);
            }
            
            $user = User::create([
                'username'  => $request->username,
                'password'  => Hash::make($request->password),
                'role'      => $request->role
            ]);

            DB::commit();

            return response()->json([
                'status'    => 200,
                'message'   => 'User Successfully Created',
                'token'     => $user->createToken($request->username)->plainTextToken
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();
            
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function show(User $user)
    {
        try { 

            if(getRole() != 'ADMIN'){
                return response()->json([
                    'status' => 401,
                    'message' => 'you do not have permission to access this API',
                ], 401);
            }
            
            return response()->json([
                'status' => 200,
                'message' => 'User Successfully Retrieved',
                'data' => $user->toArray()
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function update(UpdateUserRequest $request, User $user)
    { 
        DB::beginTransaction();

        $roles = ['ADMIN', 'PRODUCT_OWNER', 'MEMBER'];

        try {

            if(in_array($request->role, $roles) == false){
                return response()->json([
                    'status' => 401,
                    'message' => 'Only ADMIN, PRODUCT_OWNER and MEMBER role are allowed',
                ], 401);
            }

            if(getRole() != 'ADMIN'){
                return response()->json([
                    'status' => 401,
                    'message' => 'you do not have permission to access this API',
                ], 401);
            }

            $user->username = $request->username;
            $user->role = $request->role;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                $user->save();
            }else{
                $user->save();
            }
            
            DB::commit();

            return response()->json([
                'status'    => 200,
                'message'   => 'User Successfully Updated',
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function updatePassword(UpdateUserPasswordRequest $request, User $user)
    { 
        DB::beginTransaction();

        try {

            if(getRole() != 'ADMIN'){
                return response()->json([
                    'status' => 401,
                    'message' => 'you do not have permission to access this API',
                ], 401);
            }

            $user->password = Hash::make($request->password);
            $user->save();
            
            DB::commit();

            return response()->json([
                'status'    => 200,
                'message'   => 'User Password Successfully Updated',
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();

        try {

            if(getRole() != 'ADMIN'){
                return response()->json([
                    'status' => 401,
                    'message' => 'you do not have permission to access this API',
                ], 401);
            }

            $user->delete();

            DB::commit();

            return response()->json([
                'status'    => 200,
                'message'   => 'User Successfully Deleted',
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }
}
