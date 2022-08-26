<?php
namespace App\Models;

use Spatie\ResponseCache\Facades\ResponseCache;

trait ClearCacheTrait
{
    public static function bootClearCacheTrait()
    {
        self::created(function () {
            ResponseCache::clear();
        });

        self::updated(function () {
            ResponseCache::clear();
        });

        self::deleted(function () {
            ResponseCache::clear();
        });
    }
}