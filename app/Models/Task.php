<?php

namespace App\Models;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id',
        'user_id',
    ];

}
