<?php

namespace App\Helpers;

use App\Models\Task;
use App\Models\Project;

class ApiHelper
{
    // data sorting directions
    public const DATA_SORTING_DIRECTIONS = [
        'DESC',
        'ASC'
    ];

    /**
     * Getting the all available status types fror the validation
     * 
     * @return string
     */
    public static function getAllStatusTypeForValidation() : string
    {
        $returnString = '';

        foreach (Task::STATUS_TYPE_TXT as $key => $value) {
            $returnString = (!$returnString ? "in:$value" : $returnString . ",$value");
        }

        return $returnString;
    }
}