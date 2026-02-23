<?php

namespace App\Filament\Imports;

use App\Models\Product;
use App\Services\NotificationBodyBuilder;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Str;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('category')
                ->relationship()
                ->label(__('resources/product.import.columns.category'))
                ->example(__('resources/product.import.examples.category')),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->label(__('resources/product.import.columns.name'))
                ->example(__('resources/product.import.examples.name')),
            ImportColumn::make('slug')
                ->rules(['max:255'])
                ->label(__('resources/product.import.columns.slug'))
                ->example(__('resources/product.import.examples.slug')),
            ImportColumn::make('description')
                ->label(__('resources/product.import.columns.description'))
                ->example(__('resources/product.import.examples.description')),
            ImportColumn::make('is_visible')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->label(__('resources/product.import.columns.is_visible'))
                ->example(__('resources/product.import.examples.is_visible')),
            ImportColumn::make('price')
                ->numeric()
                ->rules(['integer'])
                ->label(__('resources/product.import.columns.price'))
                ->example(__('resources/product.import.examples.price')),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        return NotificationBodyBuilder::buildImportCompletedBody(
            $import,
            'resources/product.import.completed',
            'resources/product.import.failed'
        );
    }

    public function resolveRecord(): ?Product
    {
        $provided = trim((string) ($this->data['slug'] ?? ''));
        $slug = $provided !== '' ? Str::slug($provided) : Str::slug((string) ($this->data['name'] ?? ''));

        return Product::firstOrNew(['slug' => $slug]);
    }
}
