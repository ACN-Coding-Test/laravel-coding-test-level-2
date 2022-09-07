<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Http\Traits\BaseModel;

class Projects extends Model
{
    use HasFactory,BaseModel;
    public $incrementing = false;

    protected $fillable = [
        'id', 'name'
    ];
}
