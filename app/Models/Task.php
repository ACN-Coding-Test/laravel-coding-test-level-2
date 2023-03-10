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
        'status_id',
        'project_id',
        'user_id'
    ];
    public function taskUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function taskProject()
    {
        return $this->belongsTo('App\Models\Project', 'project_id');
    }
    public function taskStatus()
    {
        return $this->hasOne('App\Models\TaskStatus', 'id', 'status_id');
    }
}