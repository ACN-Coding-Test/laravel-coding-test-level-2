<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'project_id', 'user_id'];
    /**
     * Get the task associated with the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function task(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get list of NOT_STARTED tasks
     *
     * @param $query
     * @return void
     */
    public function scopeNotStarted($query)
    {
        return $query->where('status', 'NOT_STARTED');
    }

    /**
     * Get list of IN_PROGRESS tasks
     *
     * @param $query
     * @return void
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'IN_PROGRESS');
    }

    /**
     * Get list of READY_FOR_TEST tasks
     *
     * @param $query
     * @return void
     */
    public function scopeReadyForTest($query)
    {
        return $query->where('status', 'READY_FOR_TEST');
    }

    /**
     * Get list of COMPLETED tasks
     *
     * @param $query
     * @return void
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'COMPLETED');
    }
}
