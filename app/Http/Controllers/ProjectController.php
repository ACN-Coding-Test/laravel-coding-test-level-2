<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use\Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
     function getprojects(Request $request){
        
        $name=$request->q ? $request->q : '';
        $pageIndex=$request->pageIndex ? $request->pageIndex : '0';
        $pageSize=$request->pageSize ? $request->pageSize : '3';
        $sortBy=$request->sortBy ? $request->sortBy : 'name';
        $sortDirection=$request->sortDirection ? $request->sortDirection : 'ASC';
        $project_query=$data="";

        if($name){
            $project_query=Project::where("name", "like","%".$name."%");

            if($pageIndex){
                $project_query->offset($pageIndex);
            }
            if($pageSize){
                $project_query->limit($pageSize);
            }
            if($sortDirection){
                $project_query->orderBy($sortBy, $sortDirection);
            }
                $result = $project_query->get();
                $data = json_decode($result, true);
        }

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
