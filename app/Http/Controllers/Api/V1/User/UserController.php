<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    /**
     * @OA\Get(
     * path="/v1/user",
     * summary="User",
     * operationId="getUsers",
     * tags={"Users"},
     * security={ {"Bearer": {} }},
     *   @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *     ),
     *  @OA\Response(
     *        response=400,
     *        description="Bad Request",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *    ),
     *    @OA\Response(
     *        response=403,
     *        description="Forbidden"
     *    ),
     *    @OA\Response(
     *        response=500,
     *        description="Internal Server Error",
     *    )
     * )
    */
    public function index()
    {
        try {
            $data = User::with('role')->get();
            $count = $data?count($data):0;
            return response()->json([
                'status' => Response::HTTP_OK,
                'total' => $count,
                'data' => $data
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     * path="/v1/user",
     * summary="Create Users",
     * operationId="createUser",
     * tags={"Users"},
     * security={ {"Bearer": {} }},
     * @OA\RequestBody(
     *      required=true,
     *      description="Create Users",
     *      @OA\JsonContent(
     *          @OA\Schema(title = "Json Create User"),
     *          example = {
                    "data": 
                    {
                        {
                            "name": "User 1",
                            "username": "user1",
                            "password": "user1pwd",
                            "role_id" : 1
                        }
                    }
     *          }
     *      ),
     * ),
     *   @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *     ),
     *  @OA\Response(
     *        response=400,
     *        description="Bad Request",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *    ),
     *    @OA\Response(
     *        response=403,
     *        description="Forbidden"
     *    ),
     *    @OA\Response(
     *        response=500,
     *        description="Internal Server Error",
     *    )
     * )
    */
    public function store(Request $request)
    {
        try {
            $credentials = $request->only('data');
            $validator = Validator::make($credentials, [
                'data'      => 'required|array',
                'data.*.name'      => 'required|max:50',
                'data.*.username'  => 'required|max:100|unique:users',
                'data.*.password'  => 'required|max:100',
                'data.*.role_id'   => 'required|integer',
            ]);

            # Cred Validation
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors(), 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
            }

            foreach ($request->data as $key => $value) {
                $value['password'] = bcrypt($value['password']);
                User::create($value);
            }

            return response()->json([
                'status' => Response::HTTP_CREATED,
                'total' => count($request->data),
                'message' => "Create User Success"
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     * path="/v1/user/{id}",
     * summary="Get User By Id",
     * operationId="getUsersId",
     * tags={"Users"},
     * security={ {"Bearer": {} }},
     * 
     * @OA\Parameter(
     *      description="id",
     *      in="path",
     *      name="id",
     *      required=true,
     *      example="",
     *      @OA\Schema(
     *          type="string",
     *          format="text"
     *      )
     * ),
     *   @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *     ),
     *  @OA\Response(
     *        response=400,
     *        description="Bad Request",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *    ),
     *    @OA\Response(
     *        response=403,
     *        description="Forbidden"
     *    ),
     *    @OA\Response(
     *        response=500,
     *        description="Internal Server Error",
     *    )
     * )
    */
    public function show($id)
    {
        try {
            $data = User::with('role')->find($id);
            if ($data) {
                return response()->json([
                    'status' => Response::HTTP_OK,
                    'data' => $data
                ], Response::HTTP_OK);
            }

            return response()->json([
                'status' => Response:: HTTP_OK,
                'message' => "Data Not Found"
            ], Response:: HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Patch(
     * path="/v1/user/{id}",
     * summary="Edit User ",
     * operationId="editUser",
     * tags={"Users"},
     * security={ {"Bearer": {} }},
     * 
     * @OA\Parameter(
     *      description="id",
     *      in="path",
     *      name="id",
     *      required=true,
     *      example="1",
     *      @OA\Schema(
     *          type="string",
     *          format="text"
     *      )
     * ),
     * @OA\RequestBody(
     *      required=true,
     *      description="Update User",
     *      @OA\JsonContent(
     *          @OA\Schema(title = "Json Update User"),
     *          example = {
                    "name": "User 1",
                    "username": "user1",
                    "password": "user1pwd",
                    "role_id" : 1
     *          }
     *      ),
     * ),
     *   @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *     ),
     *  @OA\Response(
     *        response=400,
     *        description="Bad Request",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *    ),
     *    @OA\Response(
     *        response=403,
     *        description="Forbidden"
     *    ),
     *    @OA\Response(
     *        response=500,
     *        description="Internal Server Error",
     *    )
     * )
    */
    public function userUpdate(Request $request, $id)
    {
        try {
            $data = User::find($id);
            if ($data) {
                $credentials = $request->all();
                $validator = Validator::make($credentials, [
                    'name'      => 'required|max:50',
                    'username'  => 'required|max:100|unique:users',
                    'password'  => 'required|max:100',
                    'role_id'   => 'required|integer',
                ]);

                # Cred Validation
                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors(), 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
                }

                $data->name = $request->name;
                $data->username = $request->username;
                $data->password = bcrypt($request->password);
                $data->role_id = $request->role_id;
                $data->save();

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'data' => "Update User Success"
                ], Response::HTTP_OK);
            }
            
            return response()->json([
                'status' => Response:: HTTP_OK,
                'message' => "Data Not Found"
            ], Response:: HTTP_OK);

        } catch (Exception $e) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * @OA\Delete(
     * path="/v1/user/{id}",
     * summary="Delete User By Id",
     * operationId="deleteUserId",
     * tags={"Users"},
     * security={ {"Bearer": {} }},
     * 
     * @OA\Parameter(
     *      description="id",
     *      in="path",
     *      name="id",
     *      required=true,
     *      example="",
     *      @OA\Schema(
     *          type="string",
     *          format="text"
     *      )
     * ),
     *   @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *     ),
     *  @OA\Response(
     *        response=400,
     *        description="Bad Request",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *    ),
     *    @OA\Response(
     *        response=403,
     *        description="Forbidden"
     *    ),
     *    @OA\Response(
     *        response=500,
     *        description="Internal Server Error",
     *    )
     * )
    */
    public function destroy($id)
    {
        try {
            $data = User::find($id);

            if ($data) {
                $data->delete();
                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => "delete user success"
                ], Response::HTTP_OK);
            }
            
            return response()->json([
                'status' => Response:: HTTP_OK,
                'message' => "Data Not Found"
            ], Response:: HTTP_OK);

        } catch (Exception $e) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
