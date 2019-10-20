<?php declare(strict_types=1);

namespace Mottor;

class Timer
{
    private const MILLISECONDS_IN_SECONDS = 1000;
    private const SECONDS_IN_HOUR = 3600;

    public function getCurrentTimeInMilliseconds(): int
    {
        return time() * self::MILLISECONDS_IN_SECONDS;
    }

    public function getMillisecondsMultiplier(): int
    {
        return self::MILLISECONDS_IN_SECONDS;
    }

    public function getHoursInSeconds(int $hours): int
    {
        return $hours * self::SECONDS_IN_HOUR;
    }

    public function getSecondsInHour(): int
    {
        return self::SECONDS_IN_HOUR;
    }
}
