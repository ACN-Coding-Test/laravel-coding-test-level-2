<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Support\GeneratesUuid;
class Project extends Model
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
        'name'
    ];
}
