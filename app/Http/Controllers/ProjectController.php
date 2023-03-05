<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use\Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
     function getprojects($id=null){
        if($id){
            $result = Project::find($id);
        }else{
            $result = Project::all();
        }
        $data = json_decode($result, true);
        if(!empty($data)){
            return $result;
        }else{
            return response()->json(['message'=>'No Data Found']);
        }
    }

    function createproject(Request $req){
        if(Gate::allows('isProductOwner')){
            $input['name']=$req->input('name');
            $input['product_owner_id']=$req->input('product_owner_id');
            $project = Project::create($input);
            return $project;
        }else{
            return response()->json(['message'=>'Only PRODUCT OWNER is Allowed']);
        }
    }

    function updateproject(Request $req){
        $project = Project::find($req->id);
        if($project){
            if(Gate::allows('updateProject',$project)){
                $input = $req->all();
                $result=$project->update($input);
                if($result){
                    return response()->json(['message'=>'Successfully Updated']);
                }else{
                    return response()->json(['message'=>'Update Failed']);
                }
            }else{
                return response()->json(['message'=>'Only PRODUCT OWNER is Allowed']);
            }
        }else{
                return response()->json(['message'=>'Invalid Project']);
        }

    }

}
