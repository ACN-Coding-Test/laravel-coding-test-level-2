<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    function getTasks($id=null){
        if($id){
            $result = Task::find($id);
        }else{
            $result = Task::all();
        }
        
        if((!empty($result)) && (count($result)>0)){
             return $result;
        }else{
            return response()->json(['message'=>'No Data Found']);
        }
    }

    function createtask(Request $req){
        $task = new Task;
        $task->title=$req->input('title');
        $task->description =$req->input('description');
        $task->status=$req->input('status');
        $task->project_id=$req->input('project_id');
        $task->user_id=$req->input('user_id');
        $task->save();
        return $task;
    }

    function updatetask(Request $req){
        $task = Task::find($req->id);
        $task->title=$req->input('title');
        $task->description =$req->input('description');
        $task->status=$req->input('status');
        $task->project_id=$req->input('project_id');
        $task->user_id=$req->input('user_id');
        $result=$task->save();

        if($result){
            return response()->json(['message'=>'Successfully Updated']);
        }else{
            return response()->json(['message'=>'Update Failed']);
        }
    }

    function deletetask(Request $req){
        $task = Task::find($req->id);
        $result = $task->delete();
        if($result){
            return response()->json(['message'=>'Successfully Deleted']);
        }else{
            return response()->json(['message'=>'Delete Failed']);
        }
    }
}
