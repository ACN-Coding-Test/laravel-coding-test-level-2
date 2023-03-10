<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function create(Request $request)
    {
        try {
            if (strtoupper(auth()->user()->userrole->role_name) == 'PRODUCT_OWNER') {
            //Validated
            $validateProject = Validator::make($request->all(), 
            [
                'name' => 'required',
            ]);

            if($validateProject->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateProject->errors()
                ], 401);
            }

            $project = Project::create([
                'name' => $request->name,
                'user_id' => auth()->user()->id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Project Created Successfully',
            ], 200);
        }
        else{
            return response([
                'message' => 'Only PRODUCT_OWNER Role User Can Create Project.',
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
           $data = [];
            if(strtoupper(auth()->user()->userrole->role_name) == 'ADMIN') {
            $data = Project::with('projectUser')->find($request->id);
            }else if(strtoupper(auth()->user()->userrole->role_name) == 'PRODUCT_OWNER') {
                $data = Project::with('projectUser')->where('user_id','=', auth()->user()->id)->find($request->id);
             }else{
               $data = [];
             }
               // print_r($data);
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
            $data = Project::with('projectUser')->orderby('id', 'desc')->get();
            }
            else if(strtoupper(auth()->user()->userrole->role_name) == 'PRODUCT_OWNER') {
                $data = Project::with('projectUser')->where('user_id','=', auth()->user()->id)->orderby('id', 'desc')->get();
             }else{
                return response([
                    'message' => 'Unauthorized User!!',
                ]);
             }


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
        try {
            $data = Project::findOrFail($id);
            if(strtoupper(auth()->user()->userrole->role_name) == 'PRODUCT_OWNER' && auth()->user()->id == $data->user_id) {
                $validateProject = Validator::make($request->all(),
                [
                    'name' => 'required',
                ]);

                if($validateProject->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateProject->errors()
                    ], 401);
                }

                    $data->name = $request->name;
                    $data->save();

                    return response([
                        'message' => 'Update Successful',
                    ]);
             }else{
                return response([
                    'message' => 'Only Owner Can Update Project',
                ]);
             }

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated Project.',
                'errorCode' => 4101,
            ], 400);
        }
    }
    public function patchupdate(Request $request, $id)
    {
        try {
            $data = Project::findOrFail($id);
            if(strtoupper(auth()->user()->userrole->role_name) == 'PRODUCT_OWNER' && auth()->user()->id == $data->user_id) {
                $validateProject = Validator::make($request->all(),
                [
                    'name' => 'required',
                ]);

                if($validateProject->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateProject->errors()
                    ], 401);
                }

                    $data->name = $request->name;
                    $data->save();

                    http_response_code(200);
                    return response([
                        'message' => 'Update Successful',
                    ]);
            }else{
                return response([
                    'message' => 'Only Owner Can Update Project',
                ]);
            }

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated Project.',
                'errorCode' => 4101,
            ], 400);
        }
    }
    public function delete($id)
    {
        try {
            $data = Project::find($id);
            if(strtoupper(auth()->user()->userrole->role_name) == 'PRODUCT_OWNER' && auth()->user()->id == $data->user_id) {
                 $data->delete();
                return response([
                    'message' => 'Data successfully deleted.',
                ]);
            }else{
                return response([
                    'message' => 'Only Owner Can Delete Project',
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