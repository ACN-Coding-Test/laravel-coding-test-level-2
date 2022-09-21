<?php

namespace App\Models;

use App\Traits\UuidForKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory,UuidForKey;

    protected $fillable = [
        'title',
        'description',
        'project_id',
        'user_id',
    ];
}
