<?php

namespace App\Filament\Widgets;

use App\Services\ChartDataService;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class CustomersChart extends ChartWidget
{
    protected static ?int $sort = 2;

    public function getHeading(): string | Htmlable | null
    {
        return __('widgets/customers-chart.heading');
    }

    protected function getData(): array
    {
        $data = ChartDataService::getCustomersChartData();

        return ChartDataService::buildChartResponse(
            $data,
            __('widgets/customers-chart.datasets.label'),
            __('widgets/customers-chart.labels')
        );
    }

    protected function getType(): string
    {
        return 'line';
    }
}
