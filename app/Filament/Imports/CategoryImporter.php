<?php

namespace App\Filament\Imports;

use App\Models\Category;
use App\Services\NotificationBodyBuilder;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Str;

class CategoryImporter extends Importer
{
    protected static ?string $model = Category::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->label(__('resources/category.import.columns.name'))
                ->example(__('resources/category.import.examples.name')),
            ImportColumn::make('slug')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->label(__('resources/category.import.columns.slug'))
                ->example(__('resources/category.import.examples.slug')),
            ImportColumn::make('description')
                ->label(__('resources/category.import.columns.description'))
                ->example(__('resources/category.import.examples.description')),
            ImportColumn::make('is_visible')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->label(__('resources/category.import.columns.is_visible'))
                ->example(__('resources/category.import.examples.is_visible')),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        return NotificationBodyBuilder::buildImportCompletedBody(
            $import,
            'resources/category.import.completed',
            'resources/category.import.failed'
        );
    }

    public function resolveRecord(): ?Category
    {
        $provided = trim((string) ($this->data['slug'] ?? ''));
        $slug = $provided !== '' ? Str::slug($provided) : Str::slug((string) ($this->data['name'] ?? ''));

        return Category::firstOrNew(['slug' => $slug]);
    }
}
