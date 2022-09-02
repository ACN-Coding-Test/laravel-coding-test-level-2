<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use Uuid, HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'project_id',
        'user_id',
        'status_id'
    ];

}
