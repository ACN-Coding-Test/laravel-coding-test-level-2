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
            //Validated
            $validateTask = Validator::make($request->all(), 
            [
                'title' => 'required',
                'status_id' => 'required',
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
            Log::info("task=". $request->description);
            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'status_id' => $request->status_id,
                'user_id' => $request->user_id,
                'project_id' => $request->project_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Task Created Successfully',
            ], 200);

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
            $data = Task::find($request->id);
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
            $data = Task::orderby('id', 'desc')->paginate(2);

            http_response_code(200);
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
        $validateTask = Validator::make($request->all(),
            [
                'title' => 'required',
                'status_id' => 'required',
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
        try {
            $data = Task::findOrFail($id);
            $data->title = $request->title;
            $data->description = $request->description;
            $data->status_id = $request->status_id;
            $data->user_id = $request->user_id;
            $data->project_id = $request->project_id;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Update Successful',
            ]);

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
        $validateTask = Validator::make($request->all(),
        [
            'title' => 'required',
            'status_id' => 'required',
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
        try {
            $data = Task::findOrFail($id);
            $data->title = $request->title;
            $data->description = $request->description;
            $data->status_id = $request->status_id;
            $data->user_id = $request->user_id;
            $data->project_id = $request->project_id;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Update Successful',
            ]);

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
            $data = Task::find($id);
            $data->delete();

            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted.',
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be deleted.',
                'errorCode' => 4102,
            ], 400);
        }
    }
}
