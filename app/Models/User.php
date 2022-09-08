<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \App\Http\Traits\BaseModel;
use Laravel\Passport\HasApiTokens;
use GuzzleHttp\Client;
use Log;
use Illuminate\Support\Facades\Http;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,BaseModel;

    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $incrementing = false;

    protected $fillable = [
        'username',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function task_details()
    {
        return $this->hasMany(Task::class, 'user_id','id');
    }

    public function testGenerateToken() {
        return $this->createToken('my-oauth-client-name')->accessToken; 
    }

    public function findForPassport($username) {
        return $this->where('username', $username)->first();
    }

    public function scopeDtFilter($query,$request)
    {
        return $query->when(isset($request['q']) , function ($query) use ($request) {
                        $query->where('username','like','%'.strtoupper($request['q']).'%');
                    });
    }

    public static function generateToken($request)
    {
        $client = new Client();
        $endpoint = config('services.passport.login_endpoint');
        $client_id = config('services.passport.client_id');
        $client_secret = config('services.passport.client_secret');
        $postData = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'url' => $endpoint,
                'grant_type' => 'password',
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'username' => $request->username,
                'password' => $request->password,
            ]
        ];
        try
        {
            $response = $client->post($endpoint, $postData)->getBody()->getContents();

            return  json_decode($response);
        } 
        catch (\GuzzleHttp\Exception\BadResponseException $e)
        {
            Log::error($e->getMessage());

            if ($e->getCode() == 400)
            {
                return response()->json('Invalid Request. Please enter a email or a password.', $e->getCode());
    
            } else if ($e->getCode() == 401)
            {
                return response()->json('Your credentials are incorrect. Please try again.', $e->getCode());
            }
            return response()->json('Something went wrong on the server.', $e->getCode());
        }
    
    }
   
}
