<?php

namespace App\Models;

use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public $incrementing = false;
}
