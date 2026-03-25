<?php

namespace App\Enums;

enum UserTypesEnum
{
    public const SYSTEM_ADMIN       = 1;
    public const COMPANY_ADMIN      = 2;
    public const STAFF              = 3;


    public static function userTypes(){

        return [
            self::SYSTEM_ADMIN,
            self::COMPANY_ADMIN,
            self::STAFF

            ];
    }
}
