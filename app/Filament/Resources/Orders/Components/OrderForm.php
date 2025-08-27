<?php

namespace App\Filament\Resources\Orders\Components;

use App\Enums\OrderStatus;
use App\Filament\Resources\Products\ProductResource;
use App\Models\Order;
use App\Models\Product;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Enums\IconSize;
use Filament\Support\Enums\Size;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class OrderForm
{
    /**
     * @return array<Component>
     */
    public static function getSchema(): array
    {
        return [
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
                            TextEntry::make('created_at')
                                ->state(fn (Order $record): ?string => $record->created_at?->setTimezone('Asia/Jakarta')->diffForHumans()),

                            TextEntry::make('updated_at')
                                ->state(fn (Order $record): ?string => $record->updated_at?->setTimezone('Asia/Jakarta')->diffForHumans()),
                        ])
                        ->columnSpan(['lg' => 1])
                        ->hidden(fn (?Order $record) => $record === null),

                    Section::make()
                        ->schema([
                            TextEntry::make('total_price')
                                ->label(__('resources/order.total'))
                                ->state(fn (Order $record): ?string => $record->total_price !== null ? 'Rp ' . number_format($record->total_price, 2, ',', '.') : null),

                            static::getPaymentFormSchema(),
                        ])
                        ->columnSpan(['lg' => 1])
                        ->hidden(fn (?Order $record) => $record === null),
                ])
                ->compact()
                ->columnSpan(['lg' => 1])
                ->hidden(fn (?Order $record) => $record === null),
        ];
    }

    /** @return array<Component> */
    public static function getDetailsFormSchema(): array
    {
        return [
            static::getNumberField(),
            static::getCustomerField(),
            static::getStatusField(),
            static::getNotesField(),
        ];
    }

    protected static function getNumberField(): TextInput
    {
        return TextInput::make('number')
            ->default('OR-' . random_int(100000, 999999))
            ->disabled()
            ->dehydrated()
            ->required()
            ->maxLength(32)
            ->unique(Order::class, 'number', ignoreRecord: true);
    }

    protected static function getCustomerField(): Select
    {
        return Select::make('customer_id')
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
            ->createOptionAction(
                callback: fn (Action $action) => $action
                    ->modalHeading(__('resources/order.actions.create_customer'))
                    ->modalSubmitActionLabel(__('resources/order.actions.create_customer'))
                    ->modalWidth('lg')
            )
            ->autofocus(fn (string $operation) => $operation === 'create');
    }

    protected static function getStatusField(): ToggleButtons
    {
        return ToggleButtons::make('status')
            ->inline()
            ->options(OrderStatus::class)
            ->default(OrderStatus::New)
            ->required();
    }

    protected static function getNotesField(): MarkdownEditor
    {
        return MarkdownEditor::make('notes')
            ->columnSpanFull();
    }

    public static function getResetItemsAction(): Action
    {
        return Action::make('reset')
            ->modalHeading(__('resources/order.messages.reset_confirmation'))
            ->modalDescription(__('resources/order.messages.reset_description'))
            ->requiresConfirmation()
            ->color('danger')
            ->action(fn (Set $set) => $set(
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

    public static function getItemsRepeater(): Repeater
    {
        return Repeater::make('items')
            ->disabled(fn (?Order $record, string $operation): bool => $record?->status !== OrderStatus::New && $operation !== 'create')
            ->relationship('items')
            ->table([
                TableColumn::make('Name'),
                TableColumn::make('Qty'),
                TableColumn::make('Price'),
            ])
            ->schema([
                static::getProductIdField(),
                static::getProductNameField(),
                static::getQuantityField(),
                static::getUnitPriceField(),
            ])
            ->extraItemActions(static::getItemsRepeaterExtraItemActions())
            ->mutateRelationshipDataBeforeFillUsing(fn (array $data): ?array => $data['qty'] > 0 ? $data : null)
            ->mutateRelationshipDataBeforeCreateUsing(fn (array $data): ?array => $data['qty'] > 0 ? $data : null)
            ->mutateRelationshipDataBeforeSaveUsing(fn (array $data): ?array => $data['qty'] > 0 ? $data : null)
            ->formatStateUsing(
                static fn (?array $state, ?Order $record): array => static::formatItemsState($state, $record)
            )
            ->minItems(1)
            ->addable(false)
            ->deletable(false)
            ->reorderable(false)
            ->hiddenLabel()
            ->collapsible()
            ->required()
            ->rules([
                /**
                 * @param  array<int, array<string, mixed>>|null  $value
                 */
                fn (): Closure => static function (string $attribute, $value, Closure $fail) {
                    static::validateItemsRepeater($attribute, $value, $fail);
                },
            ]);
    }

    protected static function validateItemsRepeater(string $_attribute, mixed $value, Closure $fail): void
    {
        if (static::isValidItemsArray($value) === false) {
            $fail(__('resources/order.validation.at_least_one_item'));
        }
    }

    protected static function isValidItemsArray(mixed $value): bool
    {
        if (is_array($value) === false) {
            return false;
        }

        foreach ($value as $item) {
            if ((int) ($item['qty'] ?? 0) > 0) {
                return true;
            }
        }

        return false;
    }

    protected static function getProductIdField(): Hidden
    {
        return Hidden::make('product_id');
    }

    protected static function getProductNameField(): TextEntry
    {
        return TextEntry::make('product_name')
            ->label(__('resources/order.item.product'))
            ->state(fn (Get $get) => $get('product_name'))
            ->extraAttributes(['class' => 'h-9 flex items-center px-1']);
    }

    protected static function getQuantityField(): TextInput
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
                    ->size(Size::Small)
                    ->action(fn (Get $get, Set $set) => $set('qty', $get('qty') - 1))
                    ->disabled(fn (TextInput $component, Get $get) => $component->isDisabled() || $get('qty') <= 0),
                isInline: true
            )
            ->suffixAction(
                Action::make('increment')
                    ->iconButton()
                    ->icon('heroicon-s-plus')
                    ->iconSize(IconSize::Small)
                    ->size(Size::Small)
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

    protected static function getUnitPriceField(): TextInput
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

                    if ($product === null) {
                        return null;
                    }

                    return ProductResource::getUrl('view', ['record' => $product]);
                }, shouldOpenInNewTab: true),
        ];
    }

    /**
     * @param  array<string,mixed>|null  $state
     * @return array<int, array<string,mixed>>
     */
    protected static function formatItemsState(?array $state, ?Order $record): array
    {
        $query = static::buildProductQuery($record);
        $byId = collect($state ?? [])->keyBy('product_id');

        return $query->get()
            ->map(fn (Product $product) => static::mapProductToItemUsingIndex($product, $byId))
            ->toArray();
    }

    /** @return Builder<Product> */
    protected static function buildProductQuery(?Order $record): Builder
    {
        return Product::query()
            ->with('category')
            ->where(function ($query) use ($record) {
                $query->where(function ($q) {
                    $q->whereIsVisible(true)
                        ->whereHas('category', fn ($q) => $q->whereIsVisible(true));
                });

                if ($record !== null) {
                    $query->orWhereIn('id', $record->items()->select('product_id'));
                }
            });
    }

    /**
     * @param  Collection<int, array<string,mixed>>  $byId
     * @return array<string,mixed>
     */
    protected static function mapProductToItemUsingIndex(Product $product, Collection $byId): array
    {
        $existingItem = $byId->get($product->id);

        return [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'qty' => (int) ($existingItem['qty'] ?? 0),
            'unit_price' => $existingItem['unit_price'] ?? $product->price,
        ];
    }

    /** @return array<string,string>|Closure */
    protected static function getItemsRepeaterColStyles(): array | Closure
    {
        return static function ($operation) {
            return static::getColumnStylesForOperation($operation);
        };
    }

    /**
     * @return array<string,string>
     */
    protected static function getColumnStylesForOperation(string $operation): array
    {
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
    }

    protected static function getPaymentFormSchema(): Repeater
    {
        return Repeater::make('payment')
            ->relationship()
            ->simple(static::getPaymentAmountField())
            ->deletable(false)
            ->maxItems(1)
            ->addActionLabel(__('resources/order.actions.add_payment'))
            ->hidden(fn (?Order $record): bool => $record?->status === OrderStatus::New)
            ->label(__('resources/order.cash'))
            ->hiddenLabel(fn (?array $state) => empty($state));
    }

    protected static function getPaymentAmountField(): TextInput
    {
        return TextInput::make('amount')
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
                if ($state === 0 && $totalPrice === 0) {
                    return;
                }

                if ($state >= $totalPrice) {
                    $set('../../status', OrderStatus::Completed);
                }
            });
    }
}
