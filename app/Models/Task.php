<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function users()
    {
        return $this->hasOne(User::class);
    }
    public function projects()
    {
        return $this->hasOne(Project::class);
    }
}
