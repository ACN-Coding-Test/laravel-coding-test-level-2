<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'title' ,'description', 'status', 'project_id' ,'user_id'
    ];

    protected $rules = [
        'id'              => 'uuid|required|pk',
        'title'                => 'string|required|unique',
        'description'              => 'string',
        'status'                => 'string|required',
        'project_id'              => 'uuid|required',
        'user_id'                => 'uuid|uuid',
        
    ];

}
