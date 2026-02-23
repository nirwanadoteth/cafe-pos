<?php

namespace App\Filament\Resources\Products\Components;

use App\Models\Product;
use Closure;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

class ProductForm
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
                    static::getInventorySection(),
                    static::getAssociationsSection(),
                ])
                ->columnSpan(['lg' => 1]),
        ];
    }

    protected static function getDetailsSection(): Section
    {
        return static::getSection(null, [
            static::getNameField(),
            static::getSlugField(),
            static::getDescriptionField(),
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

    protected static function getNameField(): TextInput
    {
        return TextInput::make('name')
            ->label(__('resources/product.name'))
            ->unique('products', 'name', ignoreRecord: true)
            ->required()
            ->maxLength(255)
            ->autofocus(fn (string $operation): bool => $operation === 'create')
            ->lazy()
            ->afterStateUpdated(static::getSlugUpdateCallback());
    }

    protected static function getSlugField(): TextInput
    {
        return TextInput::make('slug')
            ->label(__('resources/product.slug'))
            ->disabled()
            ->dehydrated()
            ->required()
            ->maxLength(255)
            ->unique(Product::class, 'slug', ignoreRecord: true);
    }

    protected static function getSlugUpdateCallback(): Closure
    {
        return function (Set $set, ?string $state) {
            if ($state === null) {
                return;
            }

            $set('slug', Str::slug($state));
        };
    }

    protected static function getDescriptionField(): MarkdownEditor
    {
        return MarkdownEditor::make('description')
            ->label(__('resources/product.description'))
            ->columnSpanFull();
    }

    protected static function getImagesSection(): Section
    {
        return static::getSection(__('resources/product.images'), [
            static::getImagesField(),
        ])->collapsible();
    }

    protected static function getImagesField(): SpatieMediaLibraryFileUpload
    {
        return SpatieMediaLibraryFileUpload::make('media')
            ->collection('product-images')
            ->conversion('webp')
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->hiddenLabel();
    }

    protected static function getPricingSection(): Section
    {
        return static::getSection(__('resources/product.pricing'), [
            static::getPriceField(),
        ]);
    }

    protected static function getPriceField(): TextInput
    {
        return TextInput::make('price')
            ->label(__('resources/product.price'))
            ->numeric()
            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
            ->required();
    }

    protected static function getStatusSection(): Section
    {
        return static::getSection(__('resources/product.status'), [
            static::getVisibilityField(),
        ]);
    }

    protected static function getVisibilityField(): Toggle
    {
        return Toggle::make('is_visible')
            ->label(__('resources/product.visibility'))
            ->helperText(__('resources/product.visibility_help'))
            ->default(true);
    }

    protected static function getAssociationsSection(): Section
    {
        return static::getSection(__('resources/product.associations'), [
            static::getCategoryField(),
        ]);
    }

    protected static function getInventorySection(): Section
    {
        return static::getSection(__('resources/product.inventory'), [
            static::getStockQuantityField(),
            static::getLowStockThresholdField(),
        ]);
    }

    protected static function getStockQuantityField(): TextInput
    {
        return TextInput::make('stock_quantity')
            ->label(__('resources/product.stock_quantity'))
            ->numeric()
            ->integer()
            ->minValue(0)
            ->default(0)
            ->required();
    }

    protected static function getLowStockThresholdField(): TextInput
    {
        return TextInput::make('low_stock_threshold')
            ->label(__('resources/product.low_stock_threshold'))
            ->numeric()
            ->integer()
            ->minValue(0)
            ->helperText(__('resources/product.low_stock_threshold_help'));
    }

    protected static function getCategoryField(): Select
    {
        return Select::make('category_id')
            ->label(__('resources/product.category'))
            ->relationship('category', 'name')
            ->searchable()
            ->preload()
            ->required();
    }
}
