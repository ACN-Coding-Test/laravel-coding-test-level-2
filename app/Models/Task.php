<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task';

    /**
     * Override fillable property data.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id',
        'user_id'
    ];

    public function user(): object
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'username');
    }
    public function project(): object
    {
        return $this->belongsTo(Project::class)->select('id', 'name');
    }

}
