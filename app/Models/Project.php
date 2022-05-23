<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Project extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'name',
    ];
}
