<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use\Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    function getTasks($id=null){
        if($id){
            $result = Task::find($id);
        }else{
            $result = Task::all();
        }
        $data = json_decode($result, true);
        if(!empty($data)){
             return $result;
        }else{
            return response()->json(['message'=>'No Data Found']);
        }
    }

    function createtask(Request $req){
        $project = Project::find($req->project_id);
        if($project){
            if(Gate::allows('taskCreateByOwner',$project)){
                $input = $req->all();
                $input['task_owner_id']=$project->product_owner_id;
                $task = Task::create($input);
                return $task;
            }else{
                return response()->json(['message'=>'Only PROJECT OWNER is Allowed']);
            }
        }else{
                return response()->json(['message'=>'Invalid Project']);
        }
    }

    function updatetask(Request $req){
        $task = Task::find($req->id);
        if($task){
            if(Gate::allows('taskByOwner',$task)){
                $input = $req->all();
                $result=$task->update($input);
                if($result){
                    return response()->json(['message'=>'Successfully Updated']);
                }else{
                    return response()->json(['message'=>'Update Failed']);
                }
            }else if(Gate::allows('taskByTeamMember',$task)){
                $task->status=$req->input('status');
                $result=$task->save();
                if($result){
                    return response()->json(['message'=>'Successfully Updated']);
                }else{
                    return response()->json(['message'=>'Update Failed']);
                }
            }
            else{
                return response()->json(['message'=>'Only PROJECT OWNER OR TEAM MEMBER is Allowed']);
            }
        }else{
                return response()->json(['message'=>'Invalid Task']);
        }
    }

    function deletetask(Request $req){
        $task = Task::find($req->id);
        if($task){
            if(Gate::allows('taskByOwner',$task)){
                $result = $task->delete();
                if($result){
                    return response()->json(['message'=>'Successfully Deleted']);
                }else{
                    return response()->json(['message'=>'Delete Failed']);
                }
            }else{
                return response()->json(['message'=>'Only PRODUCT OWNER is Allowed']);
            }
        }else{
                return response()->json(['message'=>'Invalid Task']);
        }
    }

}