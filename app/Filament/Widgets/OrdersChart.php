<?php

namespace App\Filament\Widgets;

use App\Services\ChartDataService;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class OrdersChart extends ChartWidget
{
    protected static ?int $sort = 1;

    public function getHeading(): string | Htmlable | null
    {
        return __('widgets/orders-chart.heading');
    }

    protected function getData(): array
    {
        $data = ChartDataService::getOrdersChartData();

        return ChartDataService::buildChartResponse(
            $data,
            __('widgets/orders-chart.datasets.label'),
            __('widgets/orders-chart.labels')
        );
    }

    protected function getType(): string
    {
        return 'line';
    }
}
