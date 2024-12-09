<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Exports\CategoryExporter;
use App\Filament\Imports\CategoryImporter;
use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\On;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    public string $visibility = 'on';

    #[On('visibilityUpdated')]
    public function visibilityUpdated(string $value): void
    {
        $this->visibility = $value;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->importer(CategoryImporter::class),
            Actions\ExportAction::make()
                ->exporter(CategoryExporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
