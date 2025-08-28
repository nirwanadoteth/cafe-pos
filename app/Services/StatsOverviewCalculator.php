<?php

namespace App\Services;

use App\Filament\Resources\Orders\OrderResource;
use App\Helpers\DateRange;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class StatsOverviewCalculator
{
    /**
     * Calculate statistics with trend comparison
     *
     * @return array{current: mixed, diff: int|float, trend: array<string,string>}
     */
    public static function calculateTrendComparison(string $table, ?string $column, DateRange $range): array
    {
        $current = self::getCurrentValue($table, $column, $range);
        $previous = self::getPreviousValue($table, $column, $range);

        $diff = $current - $previous;
        $trend = self::calculateTrend($diff);

        return compact('current', 'diff', 'trend');
    }

    /**
     * Get current period value
     */
    protected static function getCurrentValue(string $table, ?string $column, DateRange $range): mixed
    {
        return $column !== null
            ? self::getSum($table, $column, $range->start, $range->end)
            : self::getCount($table, $range->start, $range->end);
    }

    /**
     * Get previous period value
     */
    protected static function getPreviousValue(string $table, ?string $column, DateRange $range): mixed
    {
        return $column !== null
            ? self::getSum($table, $column, $range->previous()->start, $range->previous()->end)
            : self::getCount($table, $range->previous()->start, $range->previous()->end);
    }

    /**
     * Calculate sum for a specific table and column
     */
    protected static function getSum(string $table, string $column, Carbon $startDate, Carbon $endDate): mixed
    {
        $query = OrderResource::getEloquentQuery()->whereBetween('created_at', [$startDate, $endDate]);

        if ($table === 'orders') {
            $query->where('status', '!=', 'cancelled');
        }

        return $query->sum($column);
    }

    /**
     * Get count for a specific table
     */
    protected static function getCount(string $table, Carbon $startDate, Carbon $endDate): int
    {
        $query = self::buildCountQuery($table, $startDate, $endDate);

        return (int) $query->count();
    }

    /**
     * Build count query based on table type
     *
     * @return Builder<Order> | Builder<Customer>
     */
    protected static function buildCountQuery(string $table, Carbon $startDate, Carbon $endDate): Builder
    {
        if ($table === 'orders') {
            return OrderResource::getEloquentQuery()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', '!=', 'cancelled');
        }

        if ($table === 'customers') {
            return Customer::query()
                ->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Default fallback to orders
        return OrderResource::getEloquentQuery()
            ->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * @return array<string, string>
     */
    protected static function calculateTrend(int | float $diff): array
    {
        $isPositive = $diff >= 0;
        $direction = $isPositive === true ? 'increase' : 'decrease';

        return self::getTrendConfig($isPositive, $direction);
    }

    /**
     * @return array<string, string>
     */
    protected static function getTrendConfig(bool $isPositive, string $direction): array
    {
        return [
            'direction' => __('widgets/stats-overview.trend.' . $direction),
            'icon' => $isPositive === true ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down',
            'color' => $isPositive === true ? 'success' : 'danger',
        ];
    }
}
