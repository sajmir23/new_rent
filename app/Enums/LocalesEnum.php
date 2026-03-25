<?php


namespace App\Enums;

final class LocalesEnum extends Enum
{

    public const ENGLISH       = 'en';
    public const ITALIAN       = 'it';
    public const ALBANIAN      = 'al';
    public const SPANISH       = 'es';
    public const GERMAN        = 'de';
    public const FRENCH        = 'fr';


    public static function locales(){

        return [
          self::ENGLISH,
          self::ITALIAN,
          self::ALBANIAN,
          self::SPANISH,
          self::GERMAN,
          self::FRENCH,

        ];
    }
}
