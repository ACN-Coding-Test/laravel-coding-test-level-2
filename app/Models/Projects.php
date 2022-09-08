<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Http\Traits\BaseModel;

class Projects extends Model
{
    use HasFactory,BaseModel;
    public $incrementing = false;

    protected $fillable = [
        'id', 'name'
    ];

    public function task_detail(){
        return $this->hasMany(Task::class, 'project_id','id');
    }

    public function scopeDtFilter($query,$request)
    {
        return $query->when(isset($request['q']) , function ($query) use ($request) {
                        $query->where('name','like','%'.strtoupper($request['q']).'%');
                    });
    }

}
