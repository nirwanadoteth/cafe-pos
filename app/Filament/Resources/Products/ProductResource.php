<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Components\ProductForm;
use App\Filament\Resources\Products\Components\ProductInfolist;
use App\Filament\Resources\Products\Components\ProductTable;
use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\Pages\ViewProduct;
use App\Filament\Resources\Products\Widgets\ProductStats;
use App\Models\Product;
use BackedEnum;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Product::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-bolt';

    protected static ?int $navigationSort = 1;

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
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components(ProductForm::getSchema())
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(ProductTable::getColumns())
            ->filters(ProductTable::getFilters(), ProductTable::getFiltersLayout())
            ->recordActions(ProductTable::getActions())
            ->toolbarActions(ProductTable::getBulkActions())
            ->groups(ProductTable::getGroups())
            ->defaultSort('category.name');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components(ProductInfolist::getSchema())
            ->columns(3);
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
            ProductStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'view' => ViewProduct::route('/{record}'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'category.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Product $record */

        return [
            'Category' => optional($record->category)->name,
        ];
    }

    /** @return Builder<Product> */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['category']);
    }

    public static function getModelLabel(): string
    {
        return __('resources/product.single');
    }

    public static function getModelLabelPlural(): string
    {
        return __('resources/product.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources/product.nav.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources/product.plural');
    }
}
