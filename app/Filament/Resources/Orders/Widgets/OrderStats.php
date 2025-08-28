<?php

namespace App\Filament\Resources\Orders\Widgets;

use App\Filament\Resources\Orders\OrderResource;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Services\OrderStatsCalculator;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

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

        return OrderStatsCalculator::calculateStats($baseQuery, $baseTrendQuery);
    }

    protected function getCurrentTabStatus(): ?string
    {
        return $this->getPropertyValue('activeTab');
    }
}
