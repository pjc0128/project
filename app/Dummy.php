<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Dummy extends Model
{
    public static function whereInMultiple(array $columns, $values)
    {
        $valuess = array_map(function (array$values){
            return "('" . implode($values, "', '") . "')";
        }, $values);

        return static::query()->whereRaw(
            '('.implode($columns, ' , ').') in (' .implode($values, ', '). ')'
        );
    }

}
