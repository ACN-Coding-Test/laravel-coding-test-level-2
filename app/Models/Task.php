<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['title', 'description', 'status', 'project_id', 'user_id'];
    public function users()
    {
        return $this->hasOne(User::class);
    }
    public function projects()
    {
        return $this->hasOne(Project::class);
    }
}
