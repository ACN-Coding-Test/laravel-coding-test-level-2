<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProjectController extends Controller
{
        /* function to fetch all Projects */
        public function index(Request $request)
        {
            //echo "<pre>";print_r($request->sortDirection);die;
            $q = $request->q; // search keyword, will search for name

            $pageIndex  = $request->pageIndex  ? $request->pageIndex : 0;  //  the index of the page to shown, default 0

            $pageSize  = $request->pageSize  ? $request->pageSize  : 3; //  how many items to return, default 3

            $sortBy = $request->sortBy ? $request->sortBy : 'name' ; // attribute to sort, default name 

            $sortDirection  = $request->sortDirection ? $request->sortDirection : 'ASC'; //  direction of the sort, default ASC

            $query =Project::query();

            // Search by name
            if (isset($q)) {
                $query->where('name', 'LIKE', '%'.$q.'%');
            }

            // search by sort by and direction
            $query->orderBy($sortBy, $sortDirection);
            
            return $query->paginate($pageSize);
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
