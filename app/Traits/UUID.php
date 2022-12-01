<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UUID
{
	public static function boot()
	{
        parent::boot();

        static::creating(function($model){
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
        // static::creating(function($model){
        //     if ($model->getKey() == NULL) {
        //         $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
        //     }
        // });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

}
