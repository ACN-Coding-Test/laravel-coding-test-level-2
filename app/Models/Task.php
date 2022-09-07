<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Http\Traits\BaseModel;

class Task extends Model
{
    use HasFactory,BaseModel;
    public $incrementing = false;

    protected $fillable = [
        'id', 'tittle', 'description', 'status','project_id', 'user_id'
    ];

    public function user_detail(){
        return $this->hasOne(User::class, 'id','user_id');
    }
}
