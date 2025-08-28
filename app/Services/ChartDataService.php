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
     * @return array<int, int>
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
     * @return array<int, int>
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
     * Build trend data array
     *
     * @return array<int, int>
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
     * @param  array<int, int>  $data
     * @param  array<int, string>  $labels
     * @return array<string, mixed>
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
