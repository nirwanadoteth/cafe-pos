<?php

namespace App\Services;

use Flowframe\Trend\Trend;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

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
        // Clone to avoid mutating the shared page table query builder
        $stats = $baseQuery->clone()->selectRaw(implode(', ', [
            'COUNT(*) as total_orders',
            "SUM(CASE WHEN status IN ('new', 'processing') THEN 1 ELSE 0 END) as open_orders",
            'AVG(total_price) as avg_price',
        ]))->first();

        $orderData = self::calculateTrendData($baseTrendQuery);

        return [
            'totalOrders' => (int) $stats->total_orders,
            'orderData' => $orderData,
            'openOrders' => (int) $stats->open_orders,
            'averagePrice' => round((float) ($stats->avg_price ?? 0) / 100, precision: 2),
        ];
    }

    /**
     * Calculate trend data for orders
     *
     * @param  Builder<\App\Models\Order>  $baseTrendQuery
     * @return \Illuminate\Support\Collection<int, \Flowframe\Trend\TrendValue>
     */
    protected static function calculateTrendData(Builder $baseTrendQuery): Collection
    {
        $trendQuery = Trend::query($baseTrendQuery)
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
