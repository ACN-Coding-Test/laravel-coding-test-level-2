<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Session;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    function index()
    {
        $user = Auth::user();
        return view('create_project_form', ['logged_in_user' => $user]);
    }

    function create(Request $request)
    {
        $request->validate([
            'name'         =>   'required'
        ]);

        $data = $request->all();

        Project::create([
            'name'  =>  $data['name']
        ]);
        return redirect('dashboard')->with('success', 'New Project created');
    }

    function projectDetails($id)
    {
        $projects = Project::find($id);
        // echo '<pre>';print_r($projects);die;
        $user = Auth::user();
        $tasks = Task::leftJoin('projects', function($join) {
            $join->on('tasks.project_id', '=', 'projects.id');
          })
          ->leftJoin('users', function($join) {
            $join->on('tasks.user_id', '=', 'users.id');
          })
          ->select('projects.name as project_name','tasks.*','users.*','tasks.id as task_id')
          ->where('project_id',$id)->get();
       
        $users = User::all();
        return view('project_detail_list', ['tasks' => $tasks,'projects' => $projects,'logged_in_user' => $user,'users' => $users]);
    }

    /* function to update status of task by team member */
    function changeStatus(Request $request)
    {
        $task_id = $request->task_id;
        $status = $request->status;
        $data = ['status'=>$status];
        Task::where(['id'=>$task_id])
                  ->update($data);
        return true;
    }



   
}