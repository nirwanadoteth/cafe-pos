<?php

namespace App\Filament\Resources\Products\Components;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Grouping\Group;

class ProductTable
{
    /** @return array<Column> */
    public static function getColumns(): array
    {
        return [
            static::getImagesColumn(),
            static::getNameColumn(),
            static::getCategoryColumn(),
            static::getPriceColumn(),
            static::getStockQuantityColumn(),
            static::getVisibilityColumn(),
        ];
    }

    protected static function getImagesColumn(): SpatieMediaLibraryImageColumn
    {
        return SpatieMediaLibraryImageColumn::make('product-image')
            ->defaultImageUrl(url('https://placehold.co/40x40.webp?text=No+Image'))
            ->square()
            ->grow(false)
            ->label(__('resources/product.image'))
            ->collection('product-images')
            ->conversion('webp')
            ->checkFileExistence(false)
            ->extraImgAttributes(fn (Product $record): array => [
                'alt' => 'Product image of ' . $record->name,
                'loading' => 'lazy',
            ]);
    }

    protected static function getNameColumn(): TextColumn
    {
        return TextColumn::make('name')
            ->label(__('resources/product.name'))
            ->searchable()
            ->sortable();
    }

    protected static function getCategoryColumn(): TextColumn
    {
        return TextColumn::make('category.name')
            ->label(__('resources/product.category'))
            ->searchable()
            ->sortable()
            ->toggleable();
    }

    protected static function getPriceColumn(): TextColumn
    {
        return TextColumn::make('price')
            ->label(__('resources/product.price'))
            ->searchable()
            ->sortable()
            ->money('IDR');
    }

    protected static function getVisibilityColumn(): ToggleColumn
    {
        return ToggleColumn::make('is_visible')
            ->label(__('resources/product.visibility'))
            ->onColor('success')
            ->offColor('danger')
            ->sortable()
            ->toggleable();
    }

    protected static function getStockQuantityColumn(): TextColumn
    {
        return TextColumn::make('stock_quantity')
            ->label(__('resources/product.stock_quantity'))
            ->numeric()
            ->sortable()
            ->badge()
            ->color(fn (Product $record): string => $record->isLowStock() ? 'danger' : 'success')
            ->formatStateUsing(function (Product $record): string {
                $stock = $record->stock_quantity;
                if ($record->isLowStock()) {
                    return $stock . ' ' . __('resources/product.low_stock');
                }

                return (string) $stock;
            })
            ->icon(fn (Product $record): string => $record->isLowStock() ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
            ->toggleable();
    }

    /** @return array<BaseFilter> */
    public static function getFilters(): array
    {
        return [
            static::getQueryBuilderFilter(),
        ];
    }

    protected static function getQueryBuilderFilter(): QueryBuilder
    {
        return QueryBuilder::make()
            ->constraints([
                TextConstraint::make('name')
                    ->label(__('resources/product.name')),
                TextConstraint::make('description')
                    ->label(__('resources/product.description')),
                NumberConstraint::make('price')
                    ->label(__('resources/product.price'))
                    ->icon('heroicon-m-currency-dollar'),
                NumberConstraint::make('stock_quantity')
                    ->label(__('resources/product.stock_quantity'))
                    ->icon('heroicon-m-cube'),
                BooleanConstraint::make('is_visible')
                    ->label(__('resources/product.visibility')),
            ])
            ->constraintPickerColumns();
    }

    public static function getFiltersLayout(): FiltersLayout
    {
        return FiltersLayout::AboveContentCollapsible;
    }

    /** @return Action[] */
    public static function getActions(): array
    {
        return [
            ViewAction::make(),
            EditAction::make(),
        ];
    }

    /** @return BulkActionGroup[] */
    public static function getBulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }

    /** @return Group[] */
    public static function getGroups(): array
    {
        return [
            Group::make('category.name')
                ->label(__('resources/product.category'))
                ->collapsible(),
        ];
    }
}
