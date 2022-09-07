<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

trait BaseModel
{



  protected static function bootBaseModel()
  {
    static::creating(function ($model) {
      if (!$model->getKey()) {
        $model->{$model->getKeyName()} = (string) Str::orderedUuid();
      
      }
    });
  }
}
