<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

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

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    public function index($request, $limit = 3, $sort = 'created_at', $order = 'asc')
    {

        $search = isset($request['q']) ? $request['q'] : null; //search for project name
        $sort = isset($request['sortBy']) ? $request['sortBy'] : $sort;
        $order = isset($request['sortDirection ']) ? $request['sortDirection '] : $order;
        $limit = isset($request['pageSize']) ? $request['pageSize'] : $limit;

        // $page = 1;
		$paginate = $limit;

        $return = $this::with('user')->with('project');
        
        if (!is_null($search)) {
                $return = $return->whereHas('project', function($data) use($search){
                    $data->whereRaw('UPPER(name) LIKE ?', strtoupper('%'.urldecode($search).'%'));
                });
            }

        
        return $return->orderBy($sort,$order)->paginate($limit)->appends(request()->query());
    }
 
    public function show($id)
    {
        return $this::with('user')->with('project')->where('id',$id)->first();
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
    public function updateStatus($request, $id)
    {
        $authUser = Auth::User();
        $exist = $this::where('id',$id)->where('user_id',$authUser['id'])->exists();
        if($exist){
            $data = $this::where('id',$id)->where('user_id',$authUser['id'])->update([
                'status'=> $request['status'],
            ]);
            return 1;
        }else{
            return 0;
        }
        
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
