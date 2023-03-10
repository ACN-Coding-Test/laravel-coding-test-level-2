<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = User::find($request->user_id);

            if($data){
                http_response_code(200);
                return response([
                    'message' => 'Successfull',
                    'data' => $data
                ]);
          }
          else{
            http_response_code(200);
            return response([
                'message' => 'No Record Found',
            ]);
         }
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed', 
                'errorCode' => 4103
            ],400);
        }
    }
    public function getAll(Request $request)
    {
        try {           
            $data = User::orderby('id', 'desc')->get();
            http_response_code(200);
            return response([
                'message' => 'Successfull',
                'data' => $data
            ]);        
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed',
                'errorCode' => 4103
            ],400);
        }
    }
    public function update(Request $request, $id)
    {
       // Log::info("update=". $request->name);
        $validateUser = Validator::make($request->all(),
            [
                'username' => 'required',                
                'role_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
        try {
            $data = User::findOrFail($id);
            $data->username = $request->username;            
            $data->role_id = $request->role_id;
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
       // Log::info("update=". $request->name);
        $validateUser = Validator::make($request->all(),
            [
                'username' => 'required',                
                'role_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
        try {
            $data = User::findOrFail($id);
            $data->name = $request->name;
            $data->email = $request->email;
            $data->role_id = $request->role_id;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Update Successful',
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated',
                'errorCode' => 4101,
            ], 400);
        }
    }
    public function delete($id)
    {
        try {
            $data = User::find($id);
            $data->delete();

            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted',
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be deleted',
                'errorCode' => 4102,
            ], 400);
        }
    }
}