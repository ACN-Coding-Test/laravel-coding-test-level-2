<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Project extends Model
{
    use HasFactory,Uuids;

    protected $table = 'project';

    protected $fillable = [
        'name'
    ];
}
