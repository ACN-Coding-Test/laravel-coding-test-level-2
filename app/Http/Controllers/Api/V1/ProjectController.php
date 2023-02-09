<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProjectController extends Controller
{
        /* function to fetch all Projects */
        public function index()
        {
            return Project::all();
        }
    
        /* function to fetch Project for which id given in route */
        public function showProject($id)
        {
            return Project::find($id);
        }
    
        /* function to create new Project */
        public function createProject()
        {
            $data = [
                ['name'=>'Project 4']
            ];
            
            Project::insert($data);
             
            echo  "record inserted";
        }
    
        /* function to update Project with specific Id */
        public function updateProject(Request $request)
        {
            $id = $request->id;
            $data = ['name'=>'Project 5'];
            
            Project::where(['id'=>$id])
                      ->update($data);
            return Project::find($id);
        }
    
        /* function to delete Project with given Id */
        public function deleteProject(Request $request)
        {
            $id = $request->id;
            Project::where(['id'=>$id])
                      ->delete();
            echo "Project deleted successfully";
        }
}
