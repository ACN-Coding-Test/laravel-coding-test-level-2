<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Task extends Model
{
    use HasFactory,Uuids;

    protected $table = 'task';

    protected $fillable = [
        'title','dscription','status'
    ];
}
