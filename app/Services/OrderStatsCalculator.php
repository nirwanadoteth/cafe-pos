<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class OrderStatsCalculator
{
    /**
     * Calculate order statistics
     *
     * @param  Builder<\App\Models\Order>  $baseQuery
     * @param  Builder<\App\Models\Order>  $baseTrendQuery
     * @return array<string, mixed>
     */
    public static function calculateStats(Builder $baseQuery, Builder $baseTrendQuery): array
    {
        $totalOrders = $baseQuery->count();

        $orderData = self::calculateTrendData($baseTrendQuery);

        $openOrders = self::calculateOpenOrders($baseQuery);

        $averagePrice = self::calculateAveragePrice($baseQuery);

        return [
            'totalOrders' => $totalOrders,
            'orderData' => $orderData,
            'openOrders' => $openOrders,
            'averagePrice' => $averagePrice,
        ];
    }

    /**
     * Calculate trend data for orders
     *
     * @param  Builder<\App\Models\Order>  $baseTrendQuery
     * @return \Illuminate\Support\Collection<int, \Flowframe\Trend\TrendValue>
     */
    protected static function calculateTrendData(Builder $baseTrendQuery)
    {
        $trendQuery = \Flowframe\Trend\Trend::query($baseTrendQuery)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth();

        return $trendQuery->count();
    }

    /**
     * Calculate open orders count
     *
     * @param  Builder<\App\Models\Order>  $baseQuery
     */
    protected static function calculateOpenOrders(Builder $baseQuery): int
    {
        return $baseQuery->clone()
            ->whereIn('status', ['new', 'processing'])
            ->count();
    }

    /**
     * Calculate average price for orders
     *
     * @param  Builder<\App\Models\Order>  $baseQuery
     */
    protected static function calculateAveragePrice(Builder $baseQuery): float
    {
        return round((float) $baseQuery->avg('total_price') / 100, precision: 2);
    }
}
