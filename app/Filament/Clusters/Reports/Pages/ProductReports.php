<?php

namespace App\Filament\Clusters\Reports\Pages;

use App\Filament\Clusters\Reports;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class ProductReports extends Page
{
    use HasPageShield;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-chart-bar';

    protected string $view = 'filament.clusters.reports.pages.product-reports';

    protected static ?string $cluster = Reports::class;

    public function getTitle(): string | Htmlable
    {
        return __('clusters/pages/report.product.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('clusters/pages/report.product.title');
    }
}
