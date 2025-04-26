<?php

namespace App\Statuses;

class JobType
{
    public const FULL_TIME     = 1;
    public const PART_TIME     = 2;
    public const INTERNSHIP    = 3;
    public const FREELANCE     = 4;
    public const TEMPORARY     = 5;
    public const REMOTE        = 6;

    public static array $types = [
        self::FULL_TIME,
        self::PART_TIME,
        self::INTERNSHIP,
        self::FREELANCE,
        self::TEMPORARY,
        self::REMOTE,
    ];

    public static function labels(): array
    {
        return [
            self::FULL_TIME     => 'دوام كامل',
            self::PART_TIME     => 'دوام جزئي',
            self::INTERNSHIP    => 'تدريب',
            self::FREELANCE     => 'عمل حر',
            self::TEMPORARY     => 'مؤقت',
            self::REMOTE        => 'عن بُعد',
        ];
    }

    public static function label(int $type): ?string
    {
        return self::labels()[$type] ?? null;
    }
}
