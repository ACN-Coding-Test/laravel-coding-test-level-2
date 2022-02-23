<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{
    public function getProjects()
    {
        $users = Project::get();
    
        return $users;
    }

    public function getProjectById($id)
    {
        $project = Project::find($id);
        
        if (!$project) {
            return ['messages' => 'Project not found'];
        }

        return $project;
    }

    public function createNewProject($request)
    {
        $data = [
            'name' => $request->name,
        ];

        $createProject = Project::create($data);
        
        return $createProject;
    }

    public function updateProject($request, $id)
    {
        $data = [
            'name' => $request->name,
        ];
        
        $project = Project::find($id);
        if (!$project) {
            return 'Project not found';
        }
        $updateProject = $project->update($data);
        
        return 'Successfully update project.';
    }

    public function deleteProject($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return 'Project not found';
        }
        $project->delete($id);

        return 'Successfully deleted project.';
    }
}