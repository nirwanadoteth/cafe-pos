<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    use HasWidgetShield;

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                OrderResource::getEloquentQuery()->where('status', '!=', 'cancelled')
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->heading(__('widgets.latest-orders.heading'))
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('widgets.latest-orders.column.created_at.label'))
                    ->date()
                    ->sortable(),
                TextColumn::make('number')
                    ->label(__('widgets.latest-orders.column.number.label'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer.name')
                    ->label(__('widgets.latest-orders.column.customer.label'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('widgets.latest-orders.column.status.label'))
                    ->badge(),
                TextColumn::make('total_price')
                    ->label(__('widgets.latest-orders.column.total_price.label'))
                    ->searchable()
                    ->sortable()
                    ->money('IDR'),
            ])
            ->recordActions([
                Action::make('open')
                    ->label(__('widgets.latest-orders.action.edit.label'))
                    ->url(fn (Order $record): string => OrderResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
