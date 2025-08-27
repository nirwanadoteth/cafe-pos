<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Exports\ProductExporter;
use App\Filament\Imports\ProductImporter;
use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->importer(ProductImporter::class),
            ExportAction::make()
                ->exporter(ProductExporter::class),
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return ProductResource::getWidgets();
    }
}
