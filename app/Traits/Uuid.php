<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Uuid
{
    /**
     * @return void
     */
    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            try{
                $model->id = (string) Str::uuid();
            }catch (UnsatisfiedDependencyException $e){
                abort(500, $e->getMessage());
            }
        });
    }
}
