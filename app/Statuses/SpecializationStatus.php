<?php

namespace App\Statuses;

class SpecializationStatus
{
    public const SOFTWARE = 1;

    public const AI = 2;

    public const NETWORKS = 3;

    public const GENERAL = 4;

    public static array $statuses = [
        self::SOFTWARE,
        self::AI,
        self::NETWORKS,
        self::GENERAL,
    ];
}
