<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use App\Models\User;
use App\Models\Projects;
use App\Models\MasterStatus;

class Tasks extends Model
{
    use HasFactory, UUID;
    protected $table = 'tasks';
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function status()
    {
        return $this->belongsTo(MasterStatus::class, 'status_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
