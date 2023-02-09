<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TaskController extends Controller
{
    /* function to fetch all Tasks */
    public function index()
    {
        return Task::all();
    }

    /* function to fetch Task for which id given in route */
    public function showTask($id)
    {
        return Task::find($id);
    }

    /* function to create new Task */
    public function createTask()
    {
        $data = [
            ['title'=>'Task 4', 'description'=> 'dummy text', 'status' => 1, 'project_id' => 1, 'user_id' => 1]
        ];
        
        Task::insert($data);
         
        echo  "record inserted";
    }

    /* function to update Task with specific Id */
    public function updateTask(Request $request)
    {
        $id = $request->id;
        $data = ['title'=>'Task 5', 'description'=> 'dummy text updated', 'status' => 1, 'project_id' => 1, 'user_id' => 1];
        
        Task::where(['id'=>$id])
                  ->update($data);
        return Task::find($id);
    }

    /* function to delete Task with given Id */
    public function deleteTask(Request $request)
    {
        $id = $request->id;
        Task::where(['id'=>$id])
                  ->delete();
        echo "Task deleted successfully";
    }
}
