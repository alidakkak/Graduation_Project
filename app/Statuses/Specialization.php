<?php

namespace App\Statuses;

class Specialization
{
    public const Software_Engineering = 1;
    public const Artificial_Intelligence = 2;
    public const Networks = 3;
    public const General = 4;

    public static array $statuses = [self::Software_Engineering, self::Artificial_Intelligence, self::Networks, self::General];
}
