<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRole extends Model
{
    use HasFactory;
    protected $table = 'master_role';
    protected $guarded = [];
}
