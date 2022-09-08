<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Http\Traits\BaseModel;

class Task extends Model
{
    use HasFactory,BaseModel;
    public $incrementing = false;

    const NOT_STARTED = 'NOT_STARTED';
    const IN_PROGRESS = 'IN_PROGRESS';
    const READY_FOR_TEST = 'READY_FOR_TEST';
    const COMPLETED  = 'COMPLETED';


    protected $fillable = [
        'id', 'tittle', 'description', 'status','project_id', 'user_id'
    ];

    public function user_detail(){
        return $this->belongsTo(User::class, 'id');
    }
}
