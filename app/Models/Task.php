<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Support\GeneratesUuid;
class Task extends Model
{
    use HasFactory, GeneratesUuid;

    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The name of the column that should be used for the UUID.
     *
     * @return string
     */
    public function uuidColumn(): string
    {
        return 'id';
    }
    protected $fillable = [
        'title',
        'description',
        'project_id',
        'user_id',
        'status'

    ];
    const STATUS = [
        'NOT_STARTED' => 'not_started',
        'IN_PROGRESS' => 'inprogress',
        'READY_FOR_TEST'=>'ready_for_test',
        'COMPLETED'=>'completed'
    ];
}
