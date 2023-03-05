<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\UUID;

class Project extends Model
{
    use HasFactory, Notifiable, UUID;

    protected $fillable = [
        'name',
        'product_owner_id',
    ];

}
