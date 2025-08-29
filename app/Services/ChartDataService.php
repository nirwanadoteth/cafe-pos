<?php

namespace App\Services;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Customer;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ChartDataService
{
    /**
     * Get orders chart data for the year
     *
     * @return array<int, int> Array of monthly order counts
     */
    public static function getOrdersChartData(): array
    {
        return self::buildTrendData(
            Trend::query(OrderResource::getEloquentQuery()->where('status', '!=', 'cancelled')),
            now()->startOfYear(),
            now()->endOfYear()
        );
    }

    /**
     * Get customers chart data for the year
     *
     * @return array<int, int> Array of monthly customer counts
     */
    public static function getCustomersChartData(): array
    {
        return self::buildTrendData(
            Trend::model(Customer::class),
            now()->startOfYear(),
            now()->endOfYear()
        );
    }

    /**
     * Build trend data array from Trend query
     *
     * @param  mixed  $trend  The Trend query instance
     * @param  \Carbon\Carbon  $start  Start date for the trend
     * @param  \Carbon\Carbon  $end  End date for the trend
     * @return array<int, int> Array of aggregated values by month
     */
    private static function buildTrendData(mixed $trend, \Carbon\Carbon $start, \Carbon\Carbon $end): array
    {
        return $trend
            ->between(start: $start, end: $end)
            ->perMonth()
            ->count()
            ->map(fn (TrendValue $value) => $value->aggregate)
            ->toArray();
    }

    /**
     * Build chart response with datasets and labels
     *
     * @param  array<int, int>  $data  Chart data values
     * @param  string  $label  Label for the dataset
     * @param  array<int, string>  $labels  Labels for chart axes
     * @return array<string, mixed> Formatted chart response
     */
    public static function buildChartResponse(array $data, string $label, array $labels): array
    {
        return [
            'datasets' => [
                [
                    'label' => $label,
                    'data' => $data,
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }
}
