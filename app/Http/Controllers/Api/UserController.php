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
            if (strtoupper(auth()->user()->userrole->role_name) == 'ADMIN' || auth()->user()->id == $request->user_id) {
            $data = User::with('userrole')->find($request->user_id);
            }
            else{
                $data = [];
                return response([
                    'message' => 'Only ADMIN User Can See.',
                ]);
            }

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
           // Log::info("enter=". strtoupper(auth()->user()->userrole->role_name));
            if (strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
            $data = User::with('userrole')->orderby('id', 'desc')->get();

            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data
            ]);
         }
         else{
            return response([
                'message' => 'Only Admin User Can See!!',
                //'data' => $data
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
    public function update(Request $request, $id)
    {
       // Log::info("update=". $request->name);
        $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
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
            if (strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
                $data = User::with('userrole')->findOrFail($id);
                $data->name = $request->name;
                $data->email = $request->email;
                $data->role_id = $request->role_id;
                $data->save();

                return response([
                    'message' => 'Update Successful',
                    'data' => $data,
                ]);
            }else{
                return response([
                    'message' => 'Only Admin User Can Update!!',
                ]);
            }

        } catch (RequestException $r) {

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
                'name' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
        try {
            if (strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
                $data = User::with('userrole')->findOrFail($id);
                $data->name = $request->name;
               // $data->email = $request->email;
               // $data->role_id = $request->role_id;
                $data->save();

                http_response_code(200);
                return response([
                    'message' => 'Update Successful',
                    'data' => $data,
                ]);
            }else{
                return response([
                    'message' => 'Only Admin User Can Update!!',
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
            if (strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
            $data = User::find($id);
            $data->delete();

            return response([
                'message' => 'Data successfully deleted.',
            ]);
          }else{
            return response([
                'message' => 'Only Admin User Can delete.',
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
