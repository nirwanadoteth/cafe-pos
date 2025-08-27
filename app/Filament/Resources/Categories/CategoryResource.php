<?php

namespace App\Filament\Resources\Categories;

use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Categories\Pages\EditCategory;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\Categories\Pages\ViewCategory;
use App\Filament\Resources\Categories\RelationManagers\ProductsRelationManager;
use App\Models\Category;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Closure;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Category::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 0;

    /** @return string[] */
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
            ->components([
                Section::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('resources/category.name'))
                                    ->required()
                                    ->maxLength(255)
                                    ->autofocus(fn (string $operation) => $operation === 'create')
                                    ->lazy()
                                    ->afterStateUpdated(static::getSlugUpdateCallback()),

                                TextInput::make('slug')
                                    ->label(__('resources/category.slug'))
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Category::class, 'slug', ignoreRecord: true),
                            ]),

                        Toggle::make('is_visible')
                            ->label(__('resources/category.is_visible'))
                            ->default(true),

                        MarkdownEditor::make('description')
                            ->label(__('resources/category.description')),
                    ])
                    ->columnSpan(['lg' => fn (?Category $record) => $record === null ? 3 : 2]),
                Section::make()
                    ->schema(components: [
                        TextEntry::make('created_at')
                            ->label(__('resources/category.created_at'))
                            ->state(fn (Category $record): ?string => $record->created_at?->setTimezone('Asia/Jakarta')->diffForHumans()),

                        TextEntry::make('updated_at')
                            ->label(__('resources/category.updated_at'))
                            ->state(fn (Category $record): ?string => $record->updated_at?->setTimezone('Asia/Jakarta')->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Category $record) => $record === null),
            ])
            ->columns(3);
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('resources/category.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('products_count')
                    ->label(__('resources/category.total_products'))
                    ->counts('products')
                    ->alignCenter()
                    ->sortable(),
                ToggleColumn::make('is_visible')
                    ->label(__('resources/category.visibility'))
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('resources/category.updated_at'))
                    ->date(timezone: 'Asia/Jakarta')
                    ->dateTimeTooltip(timezone: 'Asia/Jakarta')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('resources/category.name')),
                            ]),

                        IconEntry::make('is_visible')
                            ->label(__('resources/category.visibility'))
                            ->icon(fn (string $state): string => static::getVisibilityIcon($state)),

                        TextEntry::make('description')
                            ->markdown()
                            ->label(__('resources/category.description'))
                            ->placeholder(__('resources/category.no_description')),
                    ])
                    ->columnSpan(['lg' => 2]),
                Section::make()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('resources/category.created_at'))
                            ->since()
                            ->dateTimeTooltip(timezone: 'Asia/Jakarta'),

                        TextEntry::make('updated_at')
                            ->label(__('resources/category.updated_at'))
                            ->since()
                            ->dateTimeTooltip(timezone: 'Asia/Jakarta'),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    protected static function getVisibilityIcon(string $state): string
    {
        return match ($state) {
            '1' => 'heroicon-o-check-circle',
            default => 'heroicon-o-x-circle',
        };
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'view' => ViewCategory::route('/{record}'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('resources/category.single');
    }

    public static function getModelLabelPlural(): string
    {
        return __('resources/category.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources/category.nav.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources/category.plural');
    }
}
