<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\IconSize;
use Filament\Tables\Actions\Action as TablesAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group as TablesGroup;
use Filament\Tables\Table;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;

class OrderResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Order::class;

    protected static ?string $recordTitleAttribute = 'number';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make(__('resources/order.details'))
                            ->schema(static::getDetailsFormSchema()),

                        Section::make(__('resources/order.items'))
                            ->headerActions([
                                static::getResetItemsAction(),
                            ])
                            ->schema([
                                static::getItemsRepeater(),
                            ]),
                    ])
                    ->columnSpan(['lg' => fn (?Order $record) => $record === null ? 3 : 2]),

                Section::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label(__('resources/order.created_at'))
                                    ->content(fn (Order $record): ?string => $record->created_at?->setTimezone('Asia/Jakarta')->diffForHumans()),

                                Placeholder::make('updated_at')
                                    ->label(__('resources/order.updated_at'))
                                    ->content(fn (Order $record): ?string => $record->updated_at?->setTimezone('Asia/Jakarta')->diffForHumans()),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?Order $record) => $record === null),

                        Section::make()
                            ->schema([
                                Placeholder::make('total_price')
                                    ->label(__('resources/order.total'))
                                    ->content(fn (Order $record): ?string => $record->total_price ? 'Rp ' . number_format($record->total_price, 2, ',', '.') : null),

                                static::getPaymentFormSchema(),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?Order $record) => $record === null),
                    ])
                    ->compact()
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Order $record) => $record === null),
            ])
            ->disabled(fn (?Order $record): bool => $record?->status === OrderStatus::Completed || $record?->status === OrderStatus::Cancelled)
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(static::getEloquentQuery()->with('customer'))
            ->columns([
                static::getNumberColumn(),
                static::getCustomerNameColumn(),
                static::getStatusColumn(),
                static::getTotalPriceColumn(),
                static::getCreatedAtColumn(),
            ])
            ->filters([
                TrashedFilter::make(),

                static::getCreatedAtFilter(),

                SelectFilter::make('status')
                    ->options(OrderStatus::class)
                    ->multiple()
                    ->label(__('resources/order.status')),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    static::getPdfAction(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                TablesGroup::make('created_at')
                    ->label(__('resources/order.date'))
                    ->date()
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
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
            'Customer' => optional($record->customer)->name,
        ];
    }

    /** @return Builder<Order> */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['customer', 'items']);
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::where('status', 'new')->count();
    }

    protected static function getNumberColumn(): Column
    {
        return TextColumn::make('number')
            ->label(__('resources/order.number'))
            ->searchable()
            ->sortable();
    }

    protected static function getCustomerNameColumn(): Column
    {
        return TextColumn::make('customer.name')
            ->label(__('resources/order.customer'))
            ->searchable()
            ->sortable()
            ->toggleable();
    }

    protected static function getStatusColumn(): Column
    {
        return TextColumn::make('status')
            ->badge()
            ->label(__('resources/order.status'));
    }

    protected static function getTotalPriceColumn(): Column
    {
        return TextColumn::make('total_price')
            ->label(__('resources/order.total'))
            ->searchable()
            ->sortable()
            ->summarize([
                Sum::make()
                    ->money('IDR', 100),
            ])
            ->money('IDR');
    }

    protected static function getCreatedAtColumn(): Column
    {
        return TextColumn::make('created_at')
            ->label(__('resources/order.date'))
            ->date(timezone: 'Asia/Jakarta')
            ->dateTimeTooltip(timezone: 'Asia/Jakarta')
            ->sortable()
            ->toggleable();
    }

    protected static function getCreatedAtFilter(): Filter
    {
        return Filter::make('created_at')
            ->form([
                DatePicker::make('created_from')
                    ->label(__('resources/order.filters.created_from'))
                    ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                DatePicker::make('created_until')
                    ->label(__('resources/order.filters.created_until'))
                    ->placeholder(fn ($state): string => now()->format('M d, Y')),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['created_from'] ?? null,
                        fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                    )
                    ->when(
                        $data['created_until'] ?? null,
                        fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                    );
            })
            ->indicateUsing(function (array $data): array {
                $indicators = [];
                if ($data['created_from'] ?? null) {
                    $indicators['created_from'] = __('resources/order.filters.created_from') . ' ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                }
                if ($data['created_until'] ?? null) {
                    $indicators['created_until'] = __('resources/order.filters.created_until') . ' ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                }

                return $indicators;
            });
    }

    public static function getPdfAction(): TablesAction
    {
        return TablesAction::make('pdf')
            ->label(__('resources/order.actions.pdf'))
            ->color('success')
            ->icon('heroicon-o-arrow-down-tray')
            ->action(function (Order $record) {
                $record = $record->load('customer', 'items.product', 'payment');
                $filename = 'INVOICE-' . $record->number . '-' . $record->created_at?->format('d-m-Y') . '.pdf';

                return response()->streamDownload(function () use ($record) {
                    echo Pdf::loadHtml(
                        Blade::render('invoice', ['order' => $record])
                    )->stream();
                }, $filename);
            })
            ->hidden(fn (Order $record): bool => $record->status !== OrderStatus::Completed);
    }

    /** @return Component[] */
    public static function getDetailsFormSchema(): array
    {
        return [
            TextInput::make('number')
                ->label(__('resources/order.number'))
                ->default('OR-' . random_int(100000, 999999))
                ->disabled()
                ->dehydrated()
                ->required()
                ->maxLength(32)
                ->unique(Order::class, 'number', ignoreRecord: true),

            Select::make('customer_id')
                ->label(__('resources/order.customer'))
                ->relationship('customer', 'name')
                ->preload()
                ->required()
                ->createOptionForm([
                    TextInput::make('name')
                        ->label(__('resources/order.customer.name'))
                        ->required()
                        ->maxLength(255),
                ])
                ->createOptionAction(function (Action $action) {
                    return $action
                        ->modalHeading(__('resources/order.actions.create_customer'))
                        ->modalSubmitActionLabel(__('resources/order.actions.create_customer'))
                        ->modalWidth('lg');
                })
                ->autofocus(fn (string $operation) => $operation === 'create'),

            ToggleButtons::make('status')
                ->label(__('resources/order.status'))
                ->inline()
                ->options(OrderStatus::class)
                ->default(OrderStatus::New)
                ->required(),

            MarkdownEditor::make('notes')
                ->label(__('resources/order.notes'))
                ->columnSpanFull(),
        ];
    }

    public static function getResetItemsAction(): Action
    {
        return Action::make('reset')
            ->label(__('resources/order.actions.reset'))
            ->modalHeading(__('resources/order.messages.reset_confirmation'))
            ->modalDescription(__('resources/order.messages.reset_description'))
            ->requiresConfirmation()
            ->color('danger')
            ->action(fn (Forms\Set $set) => $set(
                'items',
                Product::query()
                    ->with('category')
                    ->whereIsVisible(true)
                    ->whereHas('category', fn ($query) => $query->whereIsVisible(true))
                    ->get()
                    ->map(fn (Product $product) => [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'qty' => 0,
                        'unit_price' => $product->price,
                    ])
                    ->toArray()
            ))
            ->disabled(fn (?Order $record) => $record?->status !== OrderStatus::New);
    }

    public static function getItemsRepeater(): TableRepeater
    {
        return TableRepeater::make('items')
            ->disabled(fn (?Order $record, string $operation): bool => $record?->status !== OrderStatus::New && $operation !== 'create')
            ->relationship('items')
            ->schema([
                static::getProductIdFormComponent(),
                static::getProductNameFormComponent(),
                static::getQuantityFormComponent(),
                static::getUnitPriceFormComponent(),
            ])
            ->extraItemActions(static::getItemsRepeaterExtraItemActions())
            ->mutateRelationshipDataBeforeFillUsing(function (array $data): ?array {
                return $data['qty'] > 0 ? $data : null;
            })
            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): ?array {
                return $data['qty'] > 0 ? $data : null;
            })
            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): ?array {
                return $data['qty'] > 0 ? $data : null;
            })
            ->formatStateUsing(
                function (?array $state, ?Order $record): array {
                    $query = Product::query()
                        ->with('category')
                        ->where(function ($query) use ($record) {
                            $query->where(function ($q) {
                                $q->whereIsVisible(true)
                                    ->whereHas('category', fn ($q) => $q->whereIsVisible(true));
                            });

                            if ($record) {
                                $query->orWhereIn('id', $record->items()->pluck('product_id'));
                            }
                        });

                    return $query->get()
                        ->map(function (Product $product) use ($state) {
                            $existingItem = collect($state)->first(function ($item) use ($product) {
                                return $item['product_id'] === $product->id;
                            });

                            return [
                                'product_id' => $product->id,
                                'product_name' => $product->name,
                                'qty' => $existingItem['qty'] ?? 0,
                                'unit_price' => $existingItem['unit_price'] ?? $product->price,
                            ];
                        })
                        ->toArray();
                }
            )
            ->minItems(1)
            ->addable(false)
            ->deletable(false)
            ->reorderable(false)
            ->hiddenLabel()
            ->colStyles(static::getItemsRepeaterColStyles())
            ->collapsible()
            ->required();
    }

    protected static function getProductIdFormComponent(): Component
    {
        return Hidden::make('product_id');
    }

    protected static function getProductNameFormComponent(): Component
    {
        return Placeholder::make('product_name')
            ->label(__('resources/order.item.product'))
            ->content(fn (Get $get): string => $get('product_name'))
            ->extraAttributes(['class' => 'h-9 flex items-center px-1']);
    }

    protected static function getQuantityFormComponent(): Component
    {
        return TextInput::make('qty')
            ->label(__('resources/order.item.quantity'))
            ->inputMode('numeric')
            ->minValue(0)
            ->maxValue(999)
            ->default(0)
            ->live(debounce: 1000)
            ->prefixAction(
                Action::make('decrement')
                    ->iconButton()
                    ->icon('heroicon-s-minus')
                    ->iconSize(IconSize::Small)
                    ->size(ActionSize::Small)
                    ->action(fn (Get $get, Set $set) => $set('qty', $get('qty') - 1))
                    ->disabled(fn (TextInput $component, Get $get) => $component->isDisabled() || $get('qty') <= 0),
                isInline: true
            )
            ->suffixAction(
                Action::make('increment')
                    ->iconButton()
                    ->icon('heroicon-s-plus')
                    ->iconSize(IconSize::Small)
                    ->size(ActionSize::Small)
                    ->action(fn (Get $get, Set $set) => $set('qty', $get('qty') + 1))
                    ->disabled(fn (TextInput $component, Get $get) => $component->isDisabled() || $get('qty') >= 999),
                isInline: true
            )
            ->afterStateUpdated(function (Get $get, Set $set, $old) {
                if ($get('qty') < 0 || $get('qty') > 999) {
                    $set('qty', $old);
                }
            })
            ->extraInputAttributes(['class' => 'text-center'])
            ->required();
    }

    protected static function getUnitPriceFormComponent(): Component
    {
        return TextInput::make('unit_price')
            ->label(__('resources/order.item.unit_price'))
            ->disabled()
            ->dehydrated()
            ->numeric()
            ->required();
    }

    /** @return array<Action|Closure> */
    protected static function getItemsRepeaterExtraItemActions(): array
    {
        return [
            Action::make('resetQuantity')
                ->tooltip(__('resources/order.item.reset_qty'))
                ->icon('heroicon-m-arrow-path')
                ->color('warning')
                ->action(function (array $arguments, Repeater $component): void {
                    $items = $component->getState();
                    $items[$arguments['item']]['qty'] = 0;

                    $component->state($items);

                    $component->callAfterStateUpdated();
                })
                ->disabled(fn (?Order $record, string $operation): bool => $record?->status !== OrderStatus::New && $operation !== 'create'),

            Action::make('openProduct')
                ->tooltip(__('resources/order.item.open_product'))
                ->icon('heroicon-m-arrow-top-right-on-square')
                ->color('info')
                ->url(function (array $arguments, Repeater $component): ?string {
                    $itemData = $component->getRawItemState($arguments['item']);

                    $product = Product::find($itemData['product_id']);

                    if (! $product) {
                        return null;
                    }

                    return ProductResource::getUrl('view', ['record' => $product]);
                }, shouldOpenInNewTab: true),
        ];
    }

    /** @return array<string,string>|Closure */
    protected static function getItemsRepeaterColStyles(): array | Closure
    {
        return function ($operation) {
            if ($operation === 'create') {
                return [
                    'product_name' => 'width: 70%',
                    'qty' => 'width: 15%',
                    'unit_price' => 'width: 15%',
                ];
            }

            return [
                'product_name' => 'width: 60%',
                'qty' => 'width: 20%',
                'unit_price' => 'width: 20%',
            ];
        };
    }

    protected static function getPaymentFormSchema(): Repeater
    {
        return Repeater::make('payment')
            ->relationship()
            ->simple(
                TextInput::make('amount')
                    ->numeric()
                    ->prefix('Rp')
                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                    ->required()
                    ->step(1000)
                    ->minValue(fn ($state, Get $get) => $get('../../total_price') ?? 0)
                    ->default(fn ($state, Get $get) => $get('../../total_price') ?? 0)
                    ->columnSpanFull()
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        $totalPrice = $get('../../total_price') ?? 0;
                        if (! $state && ! $totalPrice) {
                            return;
                        }

                        if ($state >= $totalPrice) {
                            $set('../../status', OrderStatus::Completed);
                        }
                    })
            )
            ->deletable(false)
            ->maxItems(1)
            ->addActionLabel(__('resources/order.actions.add_payment'))
            ->hidden(fn (?Order $record): bool => $record?->status === OrderStatus::New)
            ->label(__('resources/order.cash'))
            ->hiddenLabel(fn (?array $state) => empty($state));
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
}
