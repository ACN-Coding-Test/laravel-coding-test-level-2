<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

use Validator;
use Hash;
use Auth;

class ApiController extends Controller
{
    public function getAllResource() 
    {
        $this->authorize('access-users');
      $users = User::get()->toJson(JSON_PRETTY_PRINT);
      return response($users, 200);
    }

    public function createResource(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required',
            'role_id'=>'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id'=>$request->role_id
        ]);
    
      return response()->json([
          "user"=>$user,
        "message" => "Resource record created"
      ], 201);
    }

    public function getResource($id) {
        $this->authorize('access-users');
      if (User::where('id', $id)->exists()) {
        $user = User::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($user, 200);
      } else {
        return response()->json([
          "message" => "Resource not found"
        ], 404);
      }
    }

    public function updateResource(Request $request, $id) {
      if (User::where('id', $id)->exists()) {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required|'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        $user->username = is_null($request->username) ? $user->username : $request->username;
        $user->password = is_null(Hash::make($request->password)) ? $user->password: Hash::make($request->password);
        $user->save();

        return response()->json([
          "message" => "records updated successfully"
        ], 200);
      } else {
        return response()->json([
          "message" => "Resource not found"
        ], 404);
      }
    }


    public function updateResourceData(Request $request, $id) {
        if (User::where('id', $id)->exists()) {
          $user = User::find($id);
        //   $validator = Validator::make($request->all(), [
        //       'username' => 'required|unique:users',
        //       'password' => 'required|'
        //   ]);
  
        //   if($validator->fails()){
        //       return response(['error' => $validator->errors()]);
        //   }
  
          $user->username = is_null($request->username) ? $user->username : $request->username;
          $user->password = is_null(Hash::make($request->password)) ? $user->password: Hash::make($request->password);
          $user->save();
  
          return response()->json([
            "message" => "records updated successfully"
          ], 200);
        } else {
          return response()->json([
            "message" => "Resource not found"
          ], 404);
        }
      }

    public function deleteResource($id) {
      if(User::where('id', $id)->exists()) {
        $user = User::find($id);
        $user->delete();

        return response()->json([
          "message" => "records deleted"
        ], 202);
      } else {
        return response()->json([
          "message" => "Resource not found"
        ], 404);
      }
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('username','password'))){
            return response([
                'errors'=>'Invalid Credentials'
            ],Response::HTTP_UNAUTHORIZED);
        }
        $user=Auth::user();
        $token=$user->createToken('token')->plainTextToken;
        return response(['jwt'=>$token]);
    }

    public function createProject(Request $request) {
      $validator = Validator::make($request->all(), [
          'name' => 'required|unique:project',
    
      ]);

      if($validator->fails()){
          return response(['error' => $validator->errors()]);
      }
      $this->authorize('access-project');
      $project = Project::create([
          'name' => $request->name
      ]);
  
    return response()->json([
        "project"=>$project,
      "message" => "Project record created"
    ], 201);
  }

  public function createTask(Request $request) {
    $validator = Validator::make($request->all(), [
        'title' => 'required',
        'description'=>'required',
        //'status' =>'required'
  
    ]);

    if($validator->fails()){
        return response(['error' => $validator->errors()]);
    }
    $this->authorize('access-task');
    $task = Task::create([
        'title' => $request->title,
        'description'=>$request->description,
        'status'=> "NOT_STARTED",
        'user_id'=>$request->user_id,
        'project_id'=>$request->project_id
    ]);

  return response()->json([
      "task"=>$task,
    "message" => "Task created"
  ], 201);
}

public function getAllProjects($name){

  if (Project::where('name', $name)->exists()) {
    $project = Project::where('name', $name)->orderBy('name','asc')->get()->toJson(JSON_PRETTY_PRINT);
    return response($project, 200);
  } else {
    return response()->json([
      "message" => "Resource not found"
    ], 404);
  }
}

}