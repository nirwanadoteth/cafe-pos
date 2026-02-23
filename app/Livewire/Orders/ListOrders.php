<?php

namespace App\Livewire\Orders;

use App\Enums\OrderStatus;
use App\Models\Order;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ListOrders extends Component implements HasActions, HasForms, HasTable
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
            // SQL: SELECT * FROM orders WHERE status = 'completed'
            ->query(
                Order::query()
                    ->where('status', '=', OrderStatus::Completed)
            )
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('clusters/pages/report.sales.table.columns.order_date'))
                    ->date(),

                TextColumn::make('min')
                    ->summarize([
                        Summarizer::make()
                            // SQL: SELECT MIN(total_price) FROM orders WHERE status = 'completed' AND [date filters]
                            ->using(fn (Builder $query) => $query->min('total_price'))
                            ->money('IDR', 100),
                    ]),

                TextColumn::make('max')
                    ->summarize([
                        Summarizer::make()
                            // SQL: SELECT MAX(total_price) FROM orders WHERE status = 'completed' AND [date filters]
                            ->using(fn (Builder $query) => $query->max('total_price'))
                            ->money('IDR', 100),
                    ]),

                TextColumn::make('sum')
                    ->summarize([
                        Summarizer::make()
                            // SQL: SELECT SUM(total_price) FROM orders WHERE status = 'completed' AND [date filters]
                            ->using(fn (Builder $query) => $query->sum('total_price'))
                            ->money('IDR', 100),
                    ]),

                TextColumn::make('avg')
                    ->summarize([
                        Summarizer::make()
                            // SQL: SELECT AVG(total_price) FROM orders WHERE status = 'completed' AND [date filters]
                            ->using(fn (Builder $query) => $query->avg('total_price'))
                            ->money('IDR', 100),
                    ]),
            ])
            ->filters([
                DateRangeFilter::make('created_at')
                    ->label(__('actions.date_range'))
                    ->defaultThisYear()
                    ->alwaysShowCalendar(false)
                    ->autoApply(),
            ])
            ->hiddenFilterIndicators()
            ->defaultGroup(Group::make('created_at')->date())
            ->groupsOnly();
    }

    public function render(): View
    {
        return view('livewire.orders.list-orders');
    }
}
