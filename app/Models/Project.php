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

    public function index($request, $limit = 15, $sort = 'created_at', $order = 'asc')
    {

        $search = isset($request['q']) ? $request['q'] : null; //search for project name
        $sort = isset($request['sortBy']) ? $request['sortBy'] : $sort;
        $order = isset($request['sortDirection ']) ? $request['sortDirection '] : $order;
        $limit = isset($request['pageSize']) ? $request['pageSize'] : $limit;

		$paginate = $limit;

        $return = $this;
        if (!is_null($search)) {
        // dd($search);
            return $return->whereRaw('UPPER(name) LIKE ?', strtoupper('%'.urldecode($search).'%'))
            ->orderBy($sort,$order)->paginate($limit)->appends(request()->query());
        }
        
        return $return->orderBy($sort,$order)->paginate($limit)->appends(request()->query());
        
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
