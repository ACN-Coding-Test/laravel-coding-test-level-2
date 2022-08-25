<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];

    const ACCESS_ROLE = [
        "ADMIN"     => "Admin",
        "PRODUCT_OWNER" => "Product Owner",
        "TEAM_MEMBER"  => "Team Member"
    ];
}
