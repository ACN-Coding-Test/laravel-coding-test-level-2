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
            if (strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
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
        }else{
            return response([
                'message' => 'Only ADMIN User Can Create Task Status.',
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
        if (strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
        try {
            $data = TaskStatus::find($request->id);

            if($data){
                return response([
                    'message' => 'Data successfully retrieved.',
                    'data' => $data
                ]);
          }
          else{
            return response([
                'message' => 'No Record Found!!',
            ]);
         }
        } catch (RequestException $r) {

            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ],400);
        }
     }else{
        return response([
            'message' => 'Only ADMIN User Can See Status.',
        ]);
     }
    }
    public function getAll(Request $request)
    {
        
            try {
                if (strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
                    $data = TaskStatus::orderby('id', 'desc')->get();
                    return response([
                        'message' => 'Data successfully retrieved.',
                        'data' => $data
                    ]);
                }else{
                    return response([
                        'message' => 'Only ADMIN User Can See Status.',
                    ]);
                }
            } catch (RequestException $r) {

                return response([
                    'message' => 'Failed to retrieve data.',
                    'errorCode' => 4103
                ],400);
            }
      
    }
    public function update(Request $request, $id)
    {
        if (strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
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
                    'data' => $data,
                ]);

            } catch (RequestException $r) {

                http_response_code(400);
                return response([
                    'message' => 'Data failed to be updated.',
                    'errorCode' => 4101,
                ], 400);
            }
        }else{
        return response([
            'message' => 'Only ADMIN User Can Update Status.',
        ]);
        }
    }
    public function patchupdate(Request $request, $id)
    {
        if (strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
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
        }else{
            return response([
                'message' => 'Only ADMIN User Can Update Status.',
            ]);
            }
    }
    public function delete($id)
    {
       
        try {
            if (strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
                $data = TaskStatus::find($id);
                $data->delete();

                http_response_code(200);
                return response([
                    'message' => 'Data successfully deleted.',
                ]);
            }else{
                return response([
                    'message' => 'Only ADMIN User Can Delete Role.',
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
