<?php

namespace App\Enums;

use ReflectionClass;

abstract class Enum
{
    public static function toArray(): array
    {
        $constants = (new ReflectionClass(static::class))->getConstants();

        return array_combine($constants, $constants);
    }

    public static function toString(): string
    {
        $glue = ',';
        return implode($glue, self::toArray());
    }
}
