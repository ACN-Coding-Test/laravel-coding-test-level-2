<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\UpdateTask;
use App\Http\Requests\Task\StoreTask;
use App\Http\Requests\Task\PatchTask;
use App\Models\Task;
use Exception;

class TaskController extends Controller
{
    public function index()
    {
        return Task::orderBy('created_at', 'asc')->get(); 
    }

    public function store(StoreTask $form)
    {
        return response()->json($form->persist());
    }

    public function show(string $id)
    {
        try {
            $task = Task::findorFail($id);
            return $task;
        } catch (Exception $e) {
           return "Task Not Found";
        }
    }

    public function update(string $id, UpdateTask $form )
    {
        $form->persist($id);
        return 'Task updated Successfully';
    }

    public function patch(string $id, PatchTask $form )
    {
        $form->persist($id);
        return 'Task patched Successfully';
    }

    public function destroy(string $id)
    {
       $Task = Task::findorFail($id); 
        if($Task->delete()){ 
            return 'deleted successfully'; 
        }
    }
}
