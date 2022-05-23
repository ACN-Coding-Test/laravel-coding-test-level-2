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
        'user_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}