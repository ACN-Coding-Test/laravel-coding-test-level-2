<?php
namespace App\Concerns;

use Illuminate\Support\Str;

trait HasUuid
{
    public static function bootHasUuid()
    {
        static::creating(function ($model) {
            $model->id = $model->id ?? Str::orderedUuid()->toString();
        });
    }
}
