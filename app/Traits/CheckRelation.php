<?php

namespace App\Traits;

trait CheckRelation
{
    public static function relationExists(string $relationName)
    {
        return (
            method_exists(self::class, $relationName) ||
            isset(static::$externalMethods[$relationName])
        );
    }
}