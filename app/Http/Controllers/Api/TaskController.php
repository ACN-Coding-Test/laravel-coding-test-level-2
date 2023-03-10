<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function create(Request $request)
    {
        try {
            if (strtoupper(auth()->user()->userrole->role_name) == 'PRODUCT_OWNER') {        
            $validateTask = Validator::make($request->all(),
            [
                'title' => 'required',               
                'user_id' => 'required',
                'project_id' => 'required',
            ]);

            if($validateTask->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateTask->errors()
                ], 401);
            }
            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'status_id' => 1, 
                'user_id' => $request->user_id,
                'project_id' => $request->project_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Task Created Successfully',
            ], 200);
        }else{
            return response([
                'message' => 'Only PRODUCT_OWNER Role User Can Create Task.',
            ]);
        }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function get(Request $request)
    {
        try {
            if(strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
            $data = Task::with(['taskUser' => function ($q) {
                return $q->select('id', 'name');
            }, 'taskProject' => function ($q) {
                return $q->select('id', 'name','user_id');
            }, 'taskStatus' => function ($q) {
                return $q->select('id', 'status');
            }])->find($request->id);
            }else if(strtoupper(auth()->user()->userrole->role_name) == 'PRODUCT_OWNER') {
                $data = Task::with(['taskUser' => function ($q) {
                    return $q->select('id', 'name');
                }, 'taskProject' => function ($q) {
                    return $q->select('id', 'name','user_id');
                }, 'taskStatus' => function ($q) {
                    return $q->select('id', 'status');
                }])->whereHas('taskProject', function ($q) {
                    return $q->where('user_id', '=', auth()->user()->id);
                })->find($request->id);
             }else if(strtoupper(auth()->user()->userrole->role_name) == 'TEAM_MEMBER') {
                $data = Task::with(['taskUser' => function ($q) {
                    return $q->select('id', 'name');
                }, 'taskProject' => function ($q) {
                    return $q->select('id', 'name','user_id');
                }, 'taskStatus' => function ($q) {
                    return $q->select('id', 'status');
                }])->where('user_id', '=', auth()->user()->id)->find($request->id);
             }
            if($data){
                http_response_code(200);
                return response([
                    'message' => 'Data successfully retrieved.',
                    'data' => $data
                ]);
          }
          else{
            http_response_code(200);
            return response([
                'message' => 'No Record Found!!',
            ]);
         }
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.', 
                'errorCode' => 4103
            ],400);
        }
    }
    public function getAll(Request $request)
    {
        try {
            $data = [];
            if(strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
            $data = Task::with(['taskUser' => function ($q) {
                return $q->select('id', 'name');
            }, 'taskProject' => function ($q) {
                return $q->select('id', 'name','user_id');
            }, 'taskStatus' => function ($q) {
                return $q->select('id', 'status');
            }])->orderby('id', 'desc')->get();
            }else if(strtoupper(auth()->user()->userrole->role_name) == 'PRODUCT_OWNER') {
                $data = Task::with(['taskUser' => function ($q) {
                    return $q->select('id', 'name');
                }, 'taskProject' => function ($q) {
                    return $q->select('id', 'name','user_id');
                }, 'taskStatus' => function ($q) {
                    return $q->select('id', 'status');
                }])->whereHas('taskProject', function ($q) {
                    return $q->where('user_id', '=', auth()->user()->id);
                })->orderby('id', 'desc')->get();
             }else if(strtoupper(auth()->user()->userrole->role_name) == 'TEAM_MEMBER') {
                $data = Task::with(['taskUser' => function ($q) {
                    return $q->select('id', 'name');
                }, 'taskProject' => function ($q) {
                    return $q->select('id', 'name','user_id');
                }, 'taskStatus' => function ($q) {
                    return $q->select('id', 'status');
                }])->orderby('id', 'desc')->where('user_id', '=', auth()->user()->id)->get();
             }
            // return view('tasklist', compact('pro'));
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ],400);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $data = Task::findOrFail($id);
            if(strtoupper(auth()->user()->userrole->role_name) == 'PRODUCT_OWNER') {
            $validateTask = Validator::make($request->all(),
            [
                'title' => 'required',
               // 'status_id' => 'required',
                'user_id' => 'required',
                'project_id' => 'required',
            ]);

            if($validateTask->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateTask->errors()
                ], 401);
            }

            $data->title = $request->title;
            $data->description = $request->description;
           // $data->status_id = $request->status_id;
            $data->user_id = $request->user_id;
            $data->project_id = $request->project_id;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Update Successful',
            ]);
        }
        else{
            return response([
                'message' => 'Only Owner Can Update Task',
            ]);
        }

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4101,
            ], 400);
        }
    }
    public function patchupdate(Request $request, $id)
    {
        try {
            $data = Task::findOrFail($id);
            if(strtoupper(auth()->user()->userrole->role_name) == 'TEAM_MEMBER') {

                if(auth()->user()->id != $data->user_id){
                    return response([
                        'message' => 'This is not your Task',
                    ]);
                }
            $validateTask = Validator::make($request->all(),
            [
                'status_id' => 'required',
            ]);
            if($validateTask->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateTask->errors()
                ], 401);
            }
            $data->status_id = $request->status_id;
            $data->save();
            return response([
                'message' => 'Update Successful',
                'data' => $data
            ]);
        }else{
            return response([
                'message' => 'Only Team Member Can Update Task Status',
            ]);
        }

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4101,
            ], 400);
        }
    }
    public function delete($id)
    {
        try {
            if(strtoupper(auth()->user()->userrole->role_name) == 'PRODUCT_OWNER') {
            $data = Task::find($id);
            $data->delete();

            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted.',
            ]);
        }else{
            return response([
                'message' => 'Only Owner Can Delete Task',
            ]); 
        }

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be deleted.',
                'errorCode' => 4102,
            ], 400);
        }
    }
}