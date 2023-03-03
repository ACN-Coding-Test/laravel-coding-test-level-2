<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->user_type == User::ROLE['PRODUCT_OWNER']){
            $tasks = Task::get();
            return response()->json(['status' => 'success','tasks'=>$tasks]);
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->user_type == User::ROLE['PRODUCT_OWNER']){
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:tasks,title|min:5|max:10',
                'description' => 'required|string|min:5|max:50',
                'project_id' => 'required'
            ]);
             
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()], 422);
            }
            if ($validator->passes()) {
                $create = Task::create([
                    'title' => $request['title'],
                    'description' => $request['description'],
                    'project_id' => $request['project_id'],
                ]);
                return response()->json(['status' => 'Task created successfully'], 201);
            }
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->user_type == User::ROLE['PRODUCT_OWNER']){
            $task = Task::find($id);
            return response()->json(['status' => 'success','task'=>$task]);
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->user_type == User::ROLE['PRODUCT_OWNER']){
            $validator = Validator::make($request->all(), [
                'title' => 'required|min:5|max:10',
                'description' => 'required|string|min:5|max:50',
                'project_id' => 'required'
            ]);
             
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()], 422);
            }
            if ($validator->passes()) {
                $updateTask = Task::where('id',$id)->firstOrFail();
                $updateTask->update([
                    'title' => $request['title'],
                    'description' => $request['description'],
                    'project_id' => $request['project_id'],
                ]);
                return response()->json(['status' => 'Task updated successfully'], 200);
            }
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->user_type == User::ROLE['PRODUCT_OWNER']){
            $task = Task::find($id);
            $task->delete();
            return response()->json(['status' => 'Task deleted successfully'], 200);
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }
    public function getTeams(){
        if(Auth::user()->user_type == User::ROLE['PRODUCT_OWNER']){
            $users = User::where('user_type',User::ROLE['TEAM_MEMBER'])->get();
            return response()->json(['status' => 'success','users'=>$users]);
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }

    public function assignTask(Request $request){
        if(Auth::user()->user_type == User::ROLE['PRODUCT_OWNER']){
            $validator = Validator::make($request->all(), [
                'team_user_id' => 'required',
                'task_id' => 'required'
            ]);
             
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()], 422);
            }
            if ($validator->passes()) {
                $updateTask = Task::find($request['task_id']);
                $updateTask->user_id = $request['team_user_id'];
                $updateTask->save();
                return response()->json(['status' => 'Task assigned successfully'], 200);
            }
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }

    public function updateStatus(Request $request){
        if(Auth::user()->user_type == User::ROLE['TEAM_MEMBER']){
            $validator = Validator::make($request->all(), [
                'status' => 'required',
                'task_id' => 'required'
            ]);
             
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()], 422);
            }
            if ($validator->passes()) {
                $updateTask = Task::find($request['task_id']);
                $updateTask->status = $request['status'];
                $updateTask->save();
                return response()->json(['status' => 'Task status updated successfully'], 200);
            }
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }
}
