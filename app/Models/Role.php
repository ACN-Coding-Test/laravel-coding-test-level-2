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
    const ADMIN ='ADMIN';
    const PRODUCT_OWNER ='PRODUCT_OWNER';
    const TEAM_MEMBER ='TEAM_MEMBER';

    public static function scopeIsAdmin($query)
    {
        return $query->where('slug',static::ADMIN);
    }
    public static function scopeIsProductOwner($query)
    {
        return $query->where('slug',static::PRODUCT_OWNER);
    }
    public static function scopeIsTeamMember($query)
    {
        return $query->where('slug',static::TEAM_MEMBER);
    }
}
