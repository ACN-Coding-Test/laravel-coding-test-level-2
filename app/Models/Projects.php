<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory, UUID;
    protected $table = 'projects';
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
