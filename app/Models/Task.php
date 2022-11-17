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
        'priority',
        'points',
        'dateline'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public $incrementing = false;
}
