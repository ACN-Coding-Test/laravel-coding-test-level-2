<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\UpdateProject;
use App\Http\Requests\Project\StoreProject;
use App\Http\Requests\Project\PatchProject;
use App\Models\Project;
use Exception;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::orderBy('created_at', 'asc')->get(); 
    }

    public function store(StoreProject $form)
    {
        return response()->json($form->persist());
    }

    public function show(string $id)
    {
        try {
            $project = Project::findorFail($id);
            return $project;
        } catch (Exception $e) {
           return 'Project Not Found';
        }
    }

    public function update(string $id, UpdateProject $form )
    {
        $form->persist($id);
        return 'Project updated Successfully';
    }

    public function patch(string $id, PatchProject $form )
    {
        $form->persist($id);
        return 'Project patched Successfully';
    }

    public function destroy(string $id)
    {
       $Project = Project::findorFail($id); 
        if($Project->delete()){ 
            return 'deleted successfully'; 
        }
    }
}
