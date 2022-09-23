<?php

namespace App\Http\Controllers\Api;

use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserRoleController extends Controller
{
    public function create(Request $request)
    {
        try {
            //Validated
            $validateRole = Validator::make($request->all(), 
            [
                'role_name' => 'required',
            ]);

            if($validateRole->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateRole->errors()
                ], 401);
            }

            $role = UserRole::create([
                'role_name' => $request->role_name,
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
            $data = UserRole::find($request->id);

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
            $data = UserRole::orderby('id', 'desc')->get();

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
        $validateRole = Validator::make($request->all(), 
        [
            'role_name' => 'required',
        ]);

        if($validateRole->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateRole->errors()
            ], 401);
        }
        try {
            $data = UserRole::findOrFail($id);
            $data->role_name = $request->role_name;
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
        $validateRole = Validator::make($request->all(), 
        [
            'role_name' => 'required',
        ]);

        if($validateRole->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateRole->errors()
            ], 401);
        }
        try {
            $data = UserRole::findOrFail($id);
            $data->role_name = $request->role_name;
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
            $data = UserRole::find($id);
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
