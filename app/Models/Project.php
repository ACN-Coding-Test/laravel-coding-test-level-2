<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Project extends Model
{
    use HasFactory;
    use FilterQueryString;
    protected $fillable = [
        'name',
        'user_id'
    ];
    protected $filters = ['name','pageIndex','pageSize'];
    public function projectUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}