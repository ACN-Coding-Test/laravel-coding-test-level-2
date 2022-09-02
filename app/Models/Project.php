<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use Uuid, HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'product_owner'
    ];

}
