<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }
    public function store($task)
    {
        return Task::find($task);
    }
    public function create(Request $request)
    {
        $task = new Task;
        $task->title=$req->title;
        $task->description=$req->description;
        $task->status=$req->email;
        $task->project_id=$req->project_id;
        $task->user_id=$req->user_id;
        $result=$task->save();
        if($result) {
          return 'file created';
        }
        else {
          return 'failed';
        }
    }
    public function update(Request $request, Task $task)
    {
        $task = Task::find($task);
        $task->title=$req->title;
        $task->description=$req->description;
        $task->status=$req->email;
        $task->project_id=$req->project_id;
        $task->user_id=$req->user_id;
        $result=$task->save();
        if($result) {
          return 'file updated';
        }
        else {
          return 'failed';
        }
    }
    public function patch(Request $request, Task $task)
    {
        $task = Task::find($task);
        if($req->title)
        {
          $task->title=$req->title;
        }
        if($req->description)
        {
          $task->description=$req->description;
        }
        if($req->email)
        {
          $task->status=$req->email;
        }
        if($req->project_id)
        {
          $task->project_id=$req->project_id;
        }
        if($req->user_id)
        {
          $task->user_id=$req->user_id;
        }
        $result=$task->save();
        if($result) {
          return 'file updated';
        }
        else {
          return 'failed';
        }
    }
    public function destroy(Task $task)
    {
        $user = User::find($user);
        $result = $user->delete();
        if($result){
          return "records has been deleted";
        }
        else {
          return "error";
        }
    }
}
