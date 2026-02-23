<?php

namespace App\Filament\Clusters\Reports\Pages;

use App\Filament\Clusters\Reports\ReportsCluster;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class SalesReports extends Page
{
    use HasFiltersForm;
    use HasPageShield;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-currency-dollar';

    protected static function getPagePermission(): ?string
    {
        return 'page_SalesReports';
    }

    protected static ?string $cluster = ReportsCluster::class;

    protected string $view = 'filament.clusters.reports.pages.sales-reports';

    public static function getNavigationLabel(): string
    {
        return __('clusters/pages/report.sales.title');
    }

    public function getTitle(): string | Htmlable
    {
        return __('clusters/pages/report.sales.title');
    }
}
