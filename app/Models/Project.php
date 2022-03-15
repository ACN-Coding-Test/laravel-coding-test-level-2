<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Models\Project;

class Project extends Model
{
    use HasFactory,Uuids;

    protected $table = 'project';

    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
