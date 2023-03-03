<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Dyrynda\Database\Support\GeneratesUuid;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, GeneratesUuid;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_name',
        'user_type',
        'password'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const ROLE = [
        'ADMIN' => 'admin',
        'PRODUCT_OWNER' => 'product_owner',
        'TEAM_MEMBER'=>'team_member'
    ];
}
