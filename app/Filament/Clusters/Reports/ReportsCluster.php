<?php

namespace App\Filament\Clusters\Reports;

use BackedEnum;
use Filament\Clusters\Cluster;
use Illuminate\Contracts\Support\Htmlable;

class ReportsCluster extends Cluster
{
    protected static BackedEnum | string | null $navigationIcon = 'heroicon-o-document-text';

    public static function getNavigationLabel(): string
    {
        return __('clusters/pages/report.title');
    }

    public static function getNavigationGroup(): string
    {
        return __('navigation.group.settings');
    }

    public static function getNavigationSort(): ?int
    {
        return 6;
    }

    public function getTitle(): string | Htmlable
    {
        return __('clusters/pages/report.title');
    }
}
