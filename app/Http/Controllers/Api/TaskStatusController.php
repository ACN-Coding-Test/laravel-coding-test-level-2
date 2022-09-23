<?php

namespace App\Http\Controllers\Api;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TaskStatusController extends Controller
{
    public function create(Request $request)
    {
        try {
            //Validated
            $validateStatus = Validator::make($request->all(), 
            [
                'status' => 'required',
            ]);

            if($validateStatus->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateStatus->errors()
                ], 401);
            }

            $status = TaskStatus::create([
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Role Created Successfully',
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
            $data = TaskStatus::find($request->id);

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
            $data = TaskStatus::orderby('id', 'desc')->get();

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
        $validateStatus = Validator::make($request->all(), 
        [
            'status' => 'required',
        ]);

        if($validateStatus->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateStatus->errors()
            ], 401);
        }
        try {
            $data = TaskStatus::findOrFail($id);
            $data->status = $request->status;
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
        $validateStatus = Validator::make($request->all(), 
        [
            'status' => 'required',
        ]);

        if($validateStatus->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateStatus->errors()
            ], 401);
        }
        try {
            $data = TaskStatus::findOrFail($id);
            $data->status = $request->status;
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
            $data = TaskStatus::find($id);
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
