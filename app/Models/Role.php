<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ADMIN = 1;
    const PRODUCT_OWNER = 2;
    const TEAM_MEMBER = 3;
    
    use HasFactory;
    protected $table = 'role';

}
