<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ListProducts extends Component implements HasActions, HasForms, HasTable
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    /**
     * @var array<string, mixed> | null
     */
    #[Url]
    public ?array $tableFilters = null;

    public function table(Table $table): Table
    {
        return $table
            // SQL: SELECT products.*, SUM(order_item.qty) AS items_sum_qty,
            //      SUM(order_item.unit_price) AS items_sum_unit_price
            //      FROM products
            //      LEFT JOIN order_item ON order_item.product_id = products.id
            //      GROUP BY products.id
            ->query(
                Product::query()
            )
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('items_sum_qty')
                    ->label(__('clusters/pages/report.product.table.columns.ordered'))
                    ->sum('items', 'qty')
                    ->default(0)
                    ->summarize([
                        Sum::make()
                            ->label(__('clusters/pages/report.product.table.summary.total_ordered')),

                        Summarizer::make()
                            ->label(__('clusters/pages/report.product.table.summary.least'))
                            ->using(
                                // SQL: SELECT name FROM <products subquery> ORDER BY items_sum_qty ASC LIMIT 1
                                fn (Builder $query) => $query
                                    ->orderBy('items_sum_qty')
                                    ->value('name') ?? '-'
                            ),
                    ]),
                TextColumn::make('items_sum_unit_price')
                    ->label(__('clusters/pages/report.product.table.columns.revenue'))
                    ->sum('items', 'unit_price')
                    ->money('IDR', 100)
                    ->summarize([
                        Sum::make('items_sum_unit_price')
                            ->label(__('clusters/pages/report.product.table.summary.total_revenue'))
                            ->money('IDR', 100),

                        Summarizer::make()
                            ->label(__('clusters/pages/report.product.table.summary.most'))
                            ->using(
                                // SQL: SELECT name FROM <products subquery> ORDER BY items_sum_qty DESC LIMIT 1
                                fn (Builder $query) => $query
                                    ->orderBy('items_sum_qty', 'desc')
                                    ->value('name') ?? '-'
                            ),
                    ]),
            ])
            ->filters([
                DateRangeFilter::make('created_at')
                    ->label(__('actions.date_range'))
                    ->defaultThisYear()
                    ->alwaysShowCalendar(false)
                    ->autoApply()
                    ->disableClear(),
            ])
            ->hiddenFilterIndicators();
    }

    public function render(): View
    {
        return view('livewire.products.list-products');
    }
}
