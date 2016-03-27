<?php

namespace App\Helpers;

class Date
{
    const DEFAULT_TIMEZONE = 'America/Montreal';

    public static function timeZone()
    {
        return new \DateTimeZone(self::DEFAULT_TIMEZONE);
    }

    public static function now()
    {
        $date = new \DateTime('now', self::timeZone());
        $date->setTimezone(self::timeZone());
        return $date;
    }
}
