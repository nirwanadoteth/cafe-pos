<?php

namespace App\Services;

use Carbon\Carbon;

class DateRangeService
{
    /**
     * Parse date string and return Carbon instances with label
     *
     * @return array{0: Carbon, 1: Carbon, 2: string}
     */
    public static function getCarbonInstancesFromDateString(?string $dateString): array
    {
        $format = 'd/m/Y';

        [$from, $to] = $dateString !== null ? explode(' - ', $dateString) : [now()->format($format), now()->format($format)];

        $parsedFrom = Carbon::createFromFormat($format, $from);
        $from = $parsedFrom !== null ? $parsedFrom : now();
        $parsedTo = Carbon::createFromFormat($format, $to);
        $to = $parsedTo !== null ? $parsedTo : now();

        $diff = $from->diffInDays($to);

        $label = self::getDateRangeLabel($diff);

        return [$from, $to, $label];
    }

    /**
     * Get appropriate date range label based on day difference
     */
    public static function getDateRangeLabel(float | int $diff): string
    {
        if ($diff >= 365) {
            return 'perYear';
        }

        if ($diff >= 30) {
            return 'perMonth';
        }

        if ($diff >= 7) {
            return 'perWeek';
        }

        return 'perDay';
    }
}
