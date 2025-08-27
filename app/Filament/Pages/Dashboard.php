<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    protected static string $routePath = '/dashboard';

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        DateRangePicker::make('created_at')
                            ->label('Date Range')
                            ->defaultThisMonth()
                            ->alwaysShowCalendar(false)
                            ->autoApply(),
                    ]),
            ]);
    }
}
