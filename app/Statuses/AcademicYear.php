<?php

namespace App\Statuses;

class AcademicYear
{
    public const First_Year = 1;
    public const Second_Year = 2;
    public const Third_Year = 3;
    public const Fourth_Year = 4;
    public const Fifth_Year = 5;
    public const General = 6;

    public static array $statuses = [self::First_Year, self::Second_Year, self::Third_Year, self::Fourth_Year, self::Fifth_Year, self::General];
}
