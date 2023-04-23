<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Authenticatable
{
    use HasFactory;

    /**
     * Override fillable property data.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'project_id',
        'user_id'
    ];

 	public function user(): object
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'username');
    }

}
