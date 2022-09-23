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
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Project Created Successfully',
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
            $data = Project::find($request->id);

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
            $data = Project::orderby('id', 'desc')->get();

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
        try {
            $data = Project::findOrFail($id);
            $data->name = $request->name;
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
        try {
            $data = Project::findOrFail($id);
            $data->name = $request->name;
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
            $data = Project::find($id);
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
