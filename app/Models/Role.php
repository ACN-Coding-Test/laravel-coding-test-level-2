<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Silber\Bouncer\Database\Role as BouncerRole;

class Role extends BouncerRole implements Auditable
{
    use SoftDeletes;
}
