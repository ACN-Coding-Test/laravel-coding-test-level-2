<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Class Uuid.
 * Manages the usage of creating UUID values for primary keys. Drop into your models as
 * per normal to use this functionality. Works right out of the box.
 * Taken from: http://garrettstjohn.com/entry/using-uuids-laravel-eloquent-orm/
 */
trait UuidForKey
{

    /**
     * The "booting" method of the model.
     */
    public static function bootUuidForKey()
    {
        static::retrieved(function (Model $model) {
            $model->incrementing = false;  // this is used after instance is loaded from DB
        });

        static::creating(function (Model $model) {
            $model->incrementing = false; // this is used for new instances

            if (empty($model->{$model->getKeyName()})) { // if it's not empty, then we want to use a specific id
                $model->{$model->getKeyName()} = (string)Uuid::uuid4();
            }
        });
    }

    public function initializeUuidForKey()
    {
        $this->keyType = 'string';
    }
}