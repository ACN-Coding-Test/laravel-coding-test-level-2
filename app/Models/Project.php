<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory,ClearCacheTrait;

    public $incrementing = false;
    public $timestamps = false;
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
    ];

    public function task(){
        return $this->hasMany(Task::class, 'project_id', 'id');
    }
}
