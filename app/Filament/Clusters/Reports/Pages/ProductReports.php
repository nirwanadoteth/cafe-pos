<?php

namespace App\Filament\Clusters\Reports\Pages;

use App\Filament\Clusters\Reports\ReportsCluster;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class ProductReports extends Page
{
    use HasPageShield;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $cluster = ReportsCluster::class;

    protected string $view = 'filament.clusters.reports.pages.product-reports';

    public static function getNavigationLabel(): string
    {
        return __('clusters/pages/report.product.title');
    }

    public function getTitle(): string | Htmlable
    {
        return __('clusters/pages/report.product.title');
    }
}
