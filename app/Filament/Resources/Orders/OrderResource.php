<?php

namespace App\Filament\Resources\Orders;

use App\Enums\OrderStatus;
use App\Filament\Resources\Orders\Components\OrderForm;
use App\Filament\Resources\Orders\Components\OrderTable;
use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Widgets\OrderStats;
use App\Models\Order;
use BackedEnum;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Order::class;

    protected static ?string $recordTitleAttribute = 'number';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 2;

    /** @return array<string> */
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'restore',
            'restore_any',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components(OrderForm::getSchema())
            ->disabled(
                fn (?Order $record): bool => $record?->status === OrderStatus::Completed ||
                    $record?->status === OrderStatus::Cancelled
            )
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(OrderTable::getColumns())
            ->filters(OrderTable::getFilters())
            ->recordActions(OrderTable::getActions())
            ->toolbarActions(OrderTable::getBulkActions())
            ->groups(OrderTable::getGroups())
            ->defaultSort('created_at', 'desc');
    }

    public static function getModelLabel(): string
    {
        return __('resources/order.single');
    }

    public static function getModelLabelPlural(): string
    {
        return __('resources/order.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources/order.nav.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources/order.plural');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Order::where('status', OrderStatus::New)->count();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }

    /** @return Builder<Order> */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['number', 'customer.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Order $record */

        return [
            'Customer' => $record->customer->name,
        ];
    }

    /** @return Builder<Order> */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        // SQL: SELECT orders.*, customers.*, order_item.*
        //      FROM orders
        //      LEFT JOIN customers ON customers.id = orders.customer_id
        //      LEFT JOIN order_item ON order_item.order_id = orders.id
        //      WHERE orders.number LIKE '%:search%'
        return parent::getGlobalSearchEloquentQuery()->with(['customer', 'items']);
    }
}
