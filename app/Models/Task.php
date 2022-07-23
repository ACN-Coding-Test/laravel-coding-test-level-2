<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'project_id',
        'user_id'
    ];

    protected $primaryKey = 'id';

    //Task Status
    const NOT_STARTED = 0;
    const IN_PROGRESS = 1;
    const READY_FOR_TEST = 2; 
    const COMPLETED = 3;

    public function index()
    {
        return $this::all();
    }
 
    public function show($id)
    {
        return $this::find($id);
    }

    public function store($request)
    {
        return $data = $this::create([
            'title'=> $request['title'],
            'description'=> isset($request['description']) ? $request['description'] : NULL,
            'status'=> $this::NOT_STARTED,
            'project_id'=> $request['project_id'],
            'user_id' => $request['user_id']
        ]);
    }
    public function updateTask($request, $id)
    {
        return $data = $this::where('id',$id)->update([
            'title'=> $request['title'],
            'description'=> isset($request['description']) ? $request['description'] : NULL,
            'status'=> $request['status'],
            'project_id'=> $request['project_id'],
            'user_id' => $request['user_id']
        ]);
    }

    public function deleteTask($id)
    {
        $exist = Task::where('project_id',$id)->exists();
        if($exist) return 0;
        else {
            return 1;
            $data = $this::where('id',$id)->delete();
        }
    }
}
