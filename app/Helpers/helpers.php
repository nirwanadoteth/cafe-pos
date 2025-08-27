<?php

use Carbon\Carbon;

if (! function_exists('getCarbonInstancesFromDateString')) {
    /**
     * @return array{0: Carbon, 1: Carbon, 2: string}
     */
    function getCarbonInstancesFromDateString(?string $dateString): array
    {
        $format = 'd/m/Y';

        [$from, $to] = $dateString ? explode(' - ', $dateString) : [now()->format($format), now()->format($format)];

        $from = Carbon::createFromFormat($format, $from) ?? now();
        $to = Carbon::createFromFormat($format, $to) ?? now();

        $diff = $from->diffInDays($to);

        $label = getDateRangeLabel($diff);

        return [$from, $to, $label];
    }
}

if (! function_exists('getDateRangeLabel')) {
    function getDateRangeLabel(float | int $diff): string
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
