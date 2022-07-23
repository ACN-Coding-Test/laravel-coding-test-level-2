<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'id',
        'name',
    ];

    protected $primaryKey = 'id';

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
        $exist = $this::where('name',$request['name'])->exists();
        if($exist) return 0;

        else {
            $data = $this::create([
                'name' => $request['name']
            ]);
            return 1;

        }
    }
    public function updateProject($request, $id)
    {
        $exist = $this::where('name',$request['name'])->where('id','!=', $id)->exists();
        if($exist) return $data = 0;
        else {
            $data = $this::where('id', $id)->update([
                'name' => $request['name']
            ]);
            return 1;
        } 
    }

    public function deleteProject($id)
    {
        $exist = Task::where('project_id',$id)->exists();
        if($exist) return 0;
        else return $data = $this::where('id',$id)->delete();
    }
}
