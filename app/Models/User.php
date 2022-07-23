<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role'
    ];

    protected $primaryKey = 'id';

    //Role
    const ADMIN  = 1;
    const PRODUCT_OWNER = 2;
    const TEAM_MEMBER = 3;

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

    public function index()
    {
        return $this::all();
    }
 
    public function show($id)
    {
        return $this::find($id);
    }

    public function store($request)
    {
        return $user = $this::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => $request['role'],
        ]);
    }

    public function updateUser($request, $id){
        
        return $user = $this::where('id',$id)->update([
            'name' => $request['name'],
            'password' => Hash::make($request['password']),
            'role' => $request['role'],
        ]);
    }

    public function deleteUser($id)
    {
        return $this::where('id',$id)->delete();
    }


}
