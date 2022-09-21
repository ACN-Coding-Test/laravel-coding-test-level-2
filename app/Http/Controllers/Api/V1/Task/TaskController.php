<?php

namespace App\Http\Controllers\Api\V1\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Models\Projects;
use App\Models\User;
use App\Models\MasterStatus;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Exception;
use JWTAuth;

class TaskController extends Controller
{
    /**
     * @OA\Get(
     * path="/v1/task",
     * summary="Tasks",
     * operationId="getTasks",
     * tags={"Tasks"},
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
            $data =  Tasks::with('project','user:id,name','status')->get();
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
     * path="/v1/task",
     * summary="Create Task",
     * operationId="storeTask",
     * tags={"Tasks"},
     * security={ {"Bearer": {} }},
     * @OA\RequestBody(
     *      required=true,
     *      description="Create Task",
     *      @OA\JsonContent(
     *          @OA\Schema(title = "Json Create Task"),
     *          example = {
                    "title": "First Task",
                    "description": "This is First Task",
                    "status_id": 1,
                    "project_id": "",
                    "user_id": "",
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
            $credentials = $request->only('title','description','status_id','project_id','user_id');
            $validator = Validator::make($credentials, [
                'title' => 'required|string|max:50',
                'description' => 'required|string',
                'status_id' => 'integer',
                'project_id' => 'required|string',
                'user_id' => 'required|string',
            ]);

            # Cred Validation
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors(), 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
            }

            $status = 1;
            if ($request->status_id) {
                if (!MasterStatus::find($request->status_id)) {
                    return response()->json(['error' => "status_id not found", 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
                }
                $status = $request->status_id;
            }

            # Check Primary key
            if (!Projects::find($request->project_id)) {
                return response()->json(['error' => "project_id not found", 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
            }

            if (!User::find($request->user_id)) {
                return response()->json(['error' => "user_id not found", 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
            }

            $currentUser = JWTAuth::authenticate($request->token);
            Tasks::create([
                "title" => $request->title,
                "description" => $request->description,
                "status_id" => $status,
                "project_id" => $request->project_id,
                "user_id" => $request->user_id,
                "created_by" => $currentUser->id
            ]);

            return response()->json([
                'status' => Response::HTTP_CREATED,
                'message' => "Create Task Success"
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'error' => $e->getMessage()." | ".$e->getFile()." | ".$e->getLine()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     * path="/v1/task/{id}",
     * summary="Show Task",
     * operationId="showTask",
     * tags={"Tasks"},
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
            $data = Tasks::with('status','user','project')->find($id);
            if ($data) {
                return response()->json([
                    'status' => Response::HTTP_OK,
                    'data' => $data
                ], Response::HTTP_OK);
            }

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => "Data Not Found"
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Patch(
     * path="/v1/task/{id}",
     * summary="Update Task",
     * operationId="updateTask",
     * tags={"Tasks"},
     * security={ {"Bearer": {} }},
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
     * @OA\RequestBody(
     *      required=true,
     *      description="Update Task",
     *      @OA\JsonContent(
     *          @OA\Schema(title = "Json Update Task"),
     *          example = {
                    "title": "First Task",
                    "description": "This is First Task",
                    "status_id": 1,
                    "project_id": "",
                    "user_id": "",
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
    public function taskUpdate(Request $request, $id)
    {
        try {
            $data = Tasks::find($id);
            if ($data) {
                $credentials = $request->only('title','description','status_id','project_id','user_id');
                $validator = Validator::make($credentials, [
                    'title' => 'required|string|max:50',
                    'description' => 'required|string',
                    'status_id' => 'integer',
                    'project_id' => 'required|string',
                    'user_id' => 'required|string',
                ]);

                # Cred Validation
                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors(), 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
                }

                # Check Foreign key
                if ($request->status_id) {
                    if (!MasterStatus::find($request->status_id)) {
                        return response()->json(['error' => "status_id not found", 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
                    }
                    $status = $request->status_id;
                }

                if (!Projects::find($request->project_id)) {
                    return response()->json(['error' => "project_id not found", 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
                }

                if (!User::find($request->user_id)) {
                    return response()->json(['error' => "user_id not found", 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
                }

                $data->title = $request->title;
                $data->description = $request->description;
                $data->status_id = $request->status_id;
                $data->project_id = $request->project_id;
                $data->user_id = $request->user_id;
                $data->save();

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'data' => "Update Task Success"
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
     * path="/v1/task/{id}",
     * summary="Delete Task By Id",
     * operationId="deleteTaskId",
     * tags={"Tasks"},
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
            $data = Tasks::find($id);

            if ($data) {
                $data->delete();
                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => "delete task success"
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
