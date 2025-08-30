<?php

namespace App\Filament\Clusters\Reports;

use BackedEnum;
use Filament\Clusters\Cluster;
use Illuminate\Contracts\Support\Htmlable;

class ReportsCluster extends Cluster
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    public function getTitle(): string | Htmlable
    {
        return __('clusters.pages.reports.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('clusters.pages.reports.title');
    }

    public static function getNavigationGroup(): string
    {
        return __('navigation.group.settings');
    }

    public static function getNavigationSort(): ?int
    {
        return 6;
    }
}
