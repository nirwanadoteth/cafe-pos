<?php

namespace App\Filament\Resources\Orders\Widgets;

use App\Filament\Resources\Orders\OrderResource;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Services\OrderStatsCalculator;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListOrders::class;
    }

    protected function getStats(): array
    {
        $baseQuery = $this->getPageTableQuery();
        $baseTrendQuery = OrderResource::getEloquentQuery();
        $status = $this->getCurrentTabStatus();
        if ($status !== null) {
            $baseQuery->where('status', $status);
            $baseTrendQuery->where('status', $status);
        }

        $stats = OrderStatsCalculator::calculateStats($baseQuery, $baseTrendQuery);

        return [
            Stat::make('Total Orders', $stats['totalOrders']),
            Stat::make('Open Orders', $stats['openOrders']),
            Stat::make('Average Price', 'Rp ' . number_format($stats['averagePrice'], 2)),
        ];
    }

    protected function getCurrentTabStatus(): ?string
    {
        return $this->getPropertyValue('activeTab');
    }
}
