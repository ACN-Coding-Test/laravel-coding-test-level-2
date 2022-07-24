<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Http\Traits\ResponseTrait;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    //
    public function __construct()
    {
        $this->project = new Project();

    }

    public function getProjects(){

        $data_projects =  $this->project->index();

        if(!$data_projects) return ResponseTrait::sendResponse(null,0,'Failed',422);

        return ResponseTrait::sendResponse($data_projects,1,'Success',200);
    }

    public function getprojectById($id){

        $data_projects =  $this->project->show($id);

        if(!$data_projects) return ResponseTrait::sendResponse(null,0,'Failed',422);

        return ResponseTrait::sendResponse($data_projects,1,'Success',200);
    }

    public function storeProject(Request $data){
        $authUser = Auth::User();
        if($authUser['role'] == User::PRODUCT_OWNER){

            $data_project = $this->project->store($data);

            // dd($data_project);
            if($data_project == 0) return ResponseTrait::sendResponse(null,1,'Name already exist',200);
            else if(!$data_project) return ResponseTrait::sendResponse(null,0,'Failed',422);

            return ResponseTrait::sendResponse($data_project,1,'Success',200);
        }else{
            return ResponseTrait::sendResponse(null,2,'Restricted User',200);
        }
    }

    public function updateProject(Request $data, $id){

        $data_project =  $this->project->updateproject($data, $id);

        if($data_project == 0) return ResponseTrait::sendResponse(null,1,'Name already exist',200);
        else if(!$data_project) return ResponseTrait::sendResponse($data,0,'Failed',422);

        return ResponseTrait::sendResponse($data_project,1,'Success',200);
    }

    public function deleteProject($id){
        $data_projects =  $this->project->deleteproject($id);
        if($data_project == 0) return ResponseTrait::sendResponse(null,1,'There are task under this project',200);
        if(!$data_projects) return ResponseTrait::sendResponse($data_projects,0,'Failed',422);

        return ResponseTrait::sendResponse($data_projects,1,'Success',200);
    }
}
