<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
	protected $table = 'project';
    /**
     * Override fillable property data.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function projcets()
    {
        return $this->hasMany(Project::class)->orderBy('id', 'desc');
    }

}
