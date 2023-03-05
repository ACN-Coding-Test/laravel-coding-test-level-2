<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
class Task extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id',
        'team_member_id',
        'task_owner_id',
    ];

}
