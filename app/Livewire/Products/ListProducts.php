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
    public ?array $filters = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
            )
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('items_sum_qty')
                    ->label(__('clusters.pages.reports.product.table.columns.ordered'))
                    ->sum('items', 'qty')
                    ->default(0)
                    ->summarize([
                        Sum::make()
                            ->label('Total ordered quantity'),

                        Summarizer::make()
                            ->label(__('clusters.pages.reports.product.table.summary.least'))
                            ->using(
                                fn (Builder $query) => $query
                                    ->orderBy('items_sum_qty', 'asc')
                                    ->value('name') ?? '-'
                            ),
                    ]),
                TextColumn::make('items_sum_unit_price')
                    ->label('Revenue')
                    ->sum('items', 'unit_price')
                    ->money('IDR', 100)
                    ->summarize([
                        Sum::make('items_sum_unit_price')
                            ->label('Total revenue')
                            ->money('IDR', 100),

                        Summarizer::make()
                            ->label(__('clusters.pages.reports.product.table.summary.most'))
                            ->using(
                                fn (Builder $query) => $query
                                    ->orderBy('items_sum_qty', 'desc')
                                    ->value('name') ?? '-'
                            ),
                    ]),
            ])
            ->filters([
                DateRangeFilter::make('created_at')
                    ->label('Date Range')
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
