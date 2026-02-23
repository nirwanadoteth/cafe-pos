<?php

namespace App\Filament\Resources\Products\Components;

use App\Models\Product;
use Closure;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Illuminate\Contracts\Support\Htmlable;

class ProductInfolist
{
    /**
     * @return array<Component>
     */
    public static function getSchema(): array
    {
        return [
            Group::make()
                ->schema([
                    static::getDetailsSection(),
                    static::getImagesSection(),
                    static::getPricingSection(),
                ])
                ->columnSpan(['lg' => 2]),

            Group::make()
                ->schema([
                    static::getStatusSection(),
                    static::getAssociationsSection(),
                    static::getTimestampsSection(),
                ])
                ->columnSpan(['lg' => 1]),
        ];
    }

    protected static function getDetailsSection(): Section
    {
        return static::getSection(null, [
            static::getNameEntry(),
            static::getSlugEntry(),
            static::getDescriptionEntry(),
        ])->columns();
    }

    /**
     * @param  string|Closure|array<Component>|Htmlable|null  $heading
     * @param  Closure|array<Component>  $schema
     */
    protected static function getSection(array | Htmlable | string | Closure | null $heading, array | Closure $schema): Section
    {
        return Section::make($heading)
            ->schema($schema);
    }

    protected static function getNameEntry(): TextEntry
    {
        return TextEntry::make('name');
    }

    protected static function getSlugEntry(): TextEntry
    {
        return TextEntry::make('slug');
    }

    protected static function getDescriptionEntry(): TextEntry
    {
        return TextEntry::make('description')
            ->markdown()
            ->placeholder(__('resources/product.no_description'))
            ->columnSpanFull();
    }

    protected static function getImagesSection(): Section
    {
        return static::getSection(__('resources/product.images'), [
            static::getImageEntry(),
        ]);
    }

    protected static function getImageEntry(): SpatieMediaLibraryImageEntry
    {
        return SpatieMediaLibraryImageEntry::make('media')
            ->collection('product-images')
            ->conversion('webp')
            ->hiddenLabel()
            ->placeholder(__('resources/product.no_images'))
            ->checkFileExistence(false)
            ->extraImgAttributes(fn (Product $record): array => [
                'alt' => 'Product image of ' . $record->name,
                'loading' => 'lazy',
            ]);
    }

    protected static function getPricingSection(): Section
    {
        return static::getSection(__('resources/product.pricing'), [
            static::getPriceEntry(),
        ]);
    }

    protected static function getPriceEntry(): TextEntry
    {
        return TextEntry::make('price')
            ->money('IDR');
    }

    protected static function getStatusSection(): Section
    {
        return static::getSection(__('resources/product.status'), [
            static::getVisibilityEntry(),
        ]);
    }

    protected static function getVisibilityEntry(): IconEntry
    {
        return IconEntry::make('is_visible')
            ->label(__('resources/product.visibility'))
            ->icon(fn (string $state): string => static::getVisibilityIcon($state));
    }

    protected static function getVisibilityIcon(string $state): string
    {
        return match ($state) {
            '1' => 'heroicon-o-check-circle',
            default => 'heroicon-o-x-circle',
        };
    }

    protected static function getAssociationsSection(): Section
    {
        return static::getSection(__('resources/product.associations'), [
            static::getCategoryEntry(),
        ]);
    }

    protected static function getCategoryEntry(): TextEntry
    {
        return TextEntry::make('category.name');
    }

    protected static function getTimestampsSection(): Section
    {
        return static::getSection(null, [
            static::getCreatedAtEntry(),
            static::getUpdatedAtEntry(),
        ]);
    }

    protected static function getCreatedAtEntry(): TextEntry
    {
        return TextEntry::make('created_at')
            ->since()
            ->dateTimeTooltip(timezone: 'Asia/Jakarta');
    }

    protected static function getUpdatedAtEntry(): TextEntry
    {
        return TextEntry::make('updated_at')
            ->since()
            ->dateTimeTooltip(timezone: 'Asia/Jakarta');
    }
}
