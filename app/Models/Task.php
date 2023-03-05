<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    // status types
    public const STATUS_TYPE_NOT_STARTED = 1;
    public const STATUS_TYPE_IN_PROGRESS = 2;
    public const STATUS_TYPE_READY_FOR_TEST = 3;
    public const STATUS_TYPE_COMPLETED = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    public function users()
    {
        $data = $this->hasOne(User::class, 'id', 'user_id');

        if(Role::ROLE_TYPE_DEVELOPER == auth()->user()->role_id) {
            $data = $data->where('id', '=', auth()->user()->id);
        }

        return $data;
    }
    
    public function projects()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////// Helping Methods
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // status types with text
    public const STATUS_TYPE_TXT = [
        self::STATUS_TYPE_NOT_STARTED => 1,
        self::STATUS_TYPE_IN_PROGRESS => 2,
        self::STATUS_TYPE_READY_FOR_TEST => 3,
        self::STATUS_TYPE_COMPLETED => 4,
    ];
}
