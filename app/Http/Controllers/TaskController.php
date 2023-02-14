<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Session;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    function index()
    {
        return view('create_task_form');
    }

    function edit(Request $request)
    {
        $projects = Project::all();
        $task_id = $request->task_id;
       
        $tasks = Task::leftJoin('projects', function($join) {
            $join->on('tasks.project_id', '=', 'projects.id');
          })
          ->leftJoin('users', function($join) {
            $join->on('tasks.user_id', '=', 'users.id');
          })
          ->select('projects.name as project_name','tasks.*','users.*','tasks.id as task_id')
          ->where('tasks.id',$task_id)->first();
        return view('edit_create_task_form', ['tasks' => $tasks, 'projects' => $projects]);
    }

    function create(Request $request)
    {
        $data = $request->all();
        Task::create([
            'title'        =>  $data['title'],
            'description'  =>  $data['description'],
            'status'       =>  0,
            'project_id'   =>  $data['project_id'],
            'user_id'      =>  $data['user_id']
        ]);
        return redirect('dashboard')->with('success', 'New Task created');
    }


    /* update task */
    function Update(Request $request)
    {

        $data = ['title'=>$request->title, 'description'=> $request->description, 'status' => $request->update_task_status];
        
        Task::where(['id'=>$request->hid_task_id])
                    ->update($data);
         return redirect()->to('projectDetails/'.$request->hid_project_id);
    }
   
}