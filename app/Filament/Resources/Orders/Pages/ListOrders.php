<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\CreateAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListOrders extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = OrderResource::class;

    public function getTabs(): array
    {
        $statuses = [
            'new' => 'info',
            'processing' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger',
        ];

        $tabs = [
            'all' => Tab::make(__('resources/order.tabs.all')),
        ];

        foreach ($statuses as $status => $color) {
            $tabs[$status] = Tab::make(__('resources/order.tabs.' . $status))
                ->query(fn ($query) => $query->where('status', $status))
                ->badge(Order::query()->where('status', $status)->count())
                ->badgeColor($color);
        }

        return $tabs;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return OrderResource::getWidgets();
    }
}
