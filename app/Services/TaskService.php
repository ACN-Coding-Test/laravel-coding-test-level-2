<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function getTasks()
    {
        $tasks = Task::get();
    
        return $tasks;
    }

    public function getTaskById($id)
    {
        $task = Task::find($id);
        
        if (!$task) {
            return ['messages' => 'Task not found'];
        }

        return $task;
    }

    public function createNewTask($request)
    {
        $createTask = Task::create($request->all());
        
        return $createTask;
    }

    public function updateTask($request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return 'Task not found';
        }
        $updateTask = $task->update($request->all());
        
        return 'Successfully update task.';
    }

    public function deleteTask($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return 'Task not found';
        }
        $task->delete($id);

        return 'Successfully deleted task.';
    }
}