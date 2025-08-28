<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Orders\OrderResource;
use App\Helpers\DateRange;
use App\Models\Customer;
use App\Services\StatsOverviewCalculator;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Illuminate\Support\Number;

class StatsOverviewWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        [$from, $to, $label] = getCarbonInstancesFromDateString(
            $this->pageFilters['created_at'] ?? null
        );
        $dateRange = new DateRange(
            $from,
            $to,
            $label
        );

        return [
            $this->createStats(
                __('widgets/stats-overview.stats.revenue.title'),
                'orders',
                'total_price',
                $dateRange,
                fn ($value) => 'Rp ' . $this->formatNumber($value)
            ),
            $this->createStats(
                __('widgets/stats-overview.stats.new_customers.title'),
                'customers',
                null,
                $dateRange
            ),
            $this->createStats(
                __('widgets/stats-overview.stats.new_orders.title'),
                'orders',
                null,
                $dateRange
            ),
        ];
    }

    private function createStats(string $title, string $table, ?string $column, DateRange $range, ?callable $formatter = null): Stat
    {
        $metrics = $this->calculateMetrics($table, $column, $range);
        $value = $formatter !== null
            ? $formatter($metrics['current'])
            : (
                $column !== null
                ? $this->formatNumber($metrics['current']) // currency (cents -> base units)
                : (string) Number::format($metrics['current'], 0, locale: config('app.locale')) // counts
            );

        return $this->buildStat(
            title: $title,
            value: $value,
            metrics: $metrics,
            chart: $this->getChartData($table, $column, $range->start, $range->end, $range->label)
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function calculateMetrics(string $table, ?string $column, DateRange $range): array
    {
        return StatsOverviewCalculator::calculateTrendComparison($table, $column, $range);
    }

    private function formatNumber(int $number): string
    {
        $number = round((float) $number / 100, 2);

        return $this->getFormattedNumber($number);
    }

    private function getFormattedNumber(float $number): string
    {
        return match (true) {
            $number < 1000 => $this->formatSmallNumber($number),
            $number < 1000000 => $this->formatThousandNumber($number),
            default => $this->formatMillionNumber($number),
        };
    }

    private function formatSmallNumber(float $number): string
    {
        return (string) Number::format($number, 0, locale: config('app.locale'));
    }

    private function formatThousandNumber(float $number): string
    {
        return Number::format($number / 1000, 2, locale: config('app.locale')) . 'k';
    }

    private function formatMillionNumber(float $number): string
    {
        return Number::format($number / 1000000, 2, locale: config('app.locale')) . 'M';
    }

    /**
     * @param  array<string, mixed>  $metrics
     * @param  array<array-key, mixed>  $chart
     */
    private function buildStat(string $title, string $value, array $metrics, array $chart): Stat
    {
        $description = $this->generateStatDescription($metrics);

        return Stat::make($title, $value)
            ->description($description)
            ->descriptionIcon($metrics['trend']['icon'])
            ->chart($chart)
            ->color($metrics['trend']['color']);
    }

    /**
     * @param  array<string, mixed>  $metrics
     */
    private function generateStatDescription(array $metrics): string
    {
        if ($metrics['current'] <= 0) {
            return '0%';
        }

        $percentage = $this->calculatePercentageChange($metrics['current'] - $metrics['diff'], $metrics['diff']);

        return $percentage . '% ' . $metrics['trend']['direction'];
    }

    private function calculatePercentageChange(int | float $oldValue, int | float $diffValue): int | float
    {
        if ($oldValue === 0) {
            return $diffValue > 0 ? 100 : 0;
        }

        return round(($diffValue / $oldValue) * 100, 2);
    }

    /**
     * @return array<array-key, mixed>
     */
    private function getChartData(string $model, ?string $column, Carbon $startDate, Carbon $endDate, string $label): array
    {
        $trend = $this->buildTrendQuery($model, $startDate, $endDate, $label);

        return $this->executeTrendQuery($trend, $column);
    }

    private function buildTrendQuery(string $model, Carbon $startDate, Carbon $endDate, string $label): mixed
    {
        $trend = $model === 'orders'
            ? Trend::query(OrderResource::getEloquentQuery()->where('status', '!=', 'cancelled'))
            : Trend::model(Customer::class);

        $trend = $trend->between(start: $startDate, end: $endDate);

        return $this->applyTrendPeriod($trend, $label);
    }

    private function applyTrendPeriod(mixed $trend, string $label): mixed
    {
        return match ($label) {
            'perYear' => $trend->perYear(),
            'perMonth' => $trend->perMonth(),
            'perWeek' => $trend->perWeek(),
            default => $trend->perDay(),
        };
    }

    /**
     * @return array<array-key, mixed>
     */
    private function executeTrendQuery(mixed $trend, ?string $column): array
    {
        if ($column !== null) {
            return $trend->sum($column)->map(fn ($value) => $value->aggregate)->toArray();
        }

        return $trend->count()->map(fn ($value) => $value->aggregate)->toArray();
    }
}
