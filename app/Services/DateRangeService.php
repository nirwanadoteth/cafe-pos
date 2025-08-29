<?php

namespace App\Services;

use Carbon\Carbon;

class DateRangeService
{
    /**
     * Parse date string and return Carbon instances with label
     *
     * @param  string|null  $dateString  Date range string in format 'd/m/Y - d/m/Y'
     * @return array{0: Carbon, 1: Carbon, 2: string} Array containing start date, end date, and period label
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
     *
     * @param  float|int  $diff  Number of days between dates
     * @return string Period label: 'perDay', 'perWeek', 'perMonth', or 'perYear'
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
