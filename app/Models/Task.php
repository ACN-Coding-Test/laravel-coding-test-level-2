<?php

namespace App\Models;

use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    use HasUuid;

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
