<?php

use App\Services\DateRangeService;
use Carbon\Carbon;

if (function_exists('getCarbonInstancesFromDateString') === false) {
    /**
     * @return array{0: Carbon, 1: Carbon, 2: string}
     */
    function getCarbonInstancesFromDateString(?string $dateString): array
    {
        return DateRangeService::getCarbonInstancesFromDateString($dateString);
    }
}

if (function_exists('getDateRangeLabel') === false) {
    function getDateRangeLabel(float | int $diff): string
    {
        return DateRangeService::getDateRangeLabel($diff);
    }
}
