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

        if ($diff >= 365) {
            $label = 'perYear';
        } elseif ($diff >= 30) {
            $label = 'perMonth';
        } elseif ($diff >= 7) {
            $label = 'perWeek';
        } else {
            $label = 'perDay';
        }

        return [$from, $to, $label];
    }
}
