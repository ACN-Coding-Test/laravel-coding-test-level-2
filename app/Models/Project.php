<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
    ];
    protected $perPage = 10;

    public function Tasks()
    {
        return $this->belongsTo('App\Models\Task');
    }

}
