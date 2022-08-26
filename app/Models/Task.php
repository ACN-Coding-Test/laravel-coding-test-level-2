<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    
    const STATUS = array(
        "NOT_STARTED"     => "NOT_STARTED",
        "IN_PROGRESS"     => "IN_PROGRESS",
        "READY_FOR_TEST"  => "READY_FOR_TEST",
        "COMPLETED"     => "COMPLETED",
    );

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'project_id',
        'user_id',
    ];

    public function project(){
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
