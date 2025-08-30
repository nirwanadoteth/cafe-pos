<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use BackedEnum;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Infolists\Components\Grid as InfolistsGrid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section as InfolistsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Category::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-tag';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        if ($state === null) {
                                            return;
                                        }

                                        $set('slug', Str::slug($state));
                                    }),

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
                    ->schema([
                        Placeholder::make('created_at')
                            ->label(__('resources/category.created_at'))
                            ->content(fn (Category $record): ?string => $record->created_at?->setTimezone('Asia/Jakarta')->diffForHumans()),

                        Placeholder::make('updated_at')
                            ->label(__('resources/category.updated_at'))
                            ->content(fn (Category $record): ?string => $record->updated_at?->setTimezone('Asia/Jakarta')->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Category $record) => $record === null),
            ])
            ->columns(3);
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
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistsSection::make()
                    ->schema([
                        InfolistsGrid::make()
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('resources/category.name')),
                            ]),

                        IconEntry::make('is_visible')
                            ->label(__('resources/category.visibility'))
                            ->icon(fn (string $state): string => match ($state) {
                                '1' => 'heroicon-o-check-circle',
                                default => 'heroicon-o-x-circle',
                            }),

                        TextEntry::make('description')
                            ->markdown()
                            ->label(__('resources/category.description'))
                            ->placeholder(__('resources/category.no_description')),
                    ])
                    ->columnSpan(['lg' => 2]),
                InfolistsSection::make()
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
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
