<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'username' => $this->username,
            'token' => $this->createToken('auth')->plainTextToken,
        ];
    }
}
