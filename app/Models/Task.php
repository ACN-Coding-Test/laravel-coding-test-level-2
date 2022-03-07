<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id',
        'user_id',
    ];


    public function User()
   {
       return $this->hasMany('App\Models\User', 'user_id', 'id');
   }
   public function Project()
   {
       return $this->hasMany('App\Models\Project', 'Project_id', 'id');
   }
}
