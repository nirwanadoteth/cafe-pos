<?php

namespace App\Filament\Exports;

use App\Models\Product;
use App\Services\NotificationBodyBuilder;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('category.name'),
            ExportColumn::make('name'),
            ExportColumn::make('slug'),
            ExportColumn::make('description'),
            ExportColumn::make('is_visible'),
            ExportColumn::make('price'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return NotificationBodyBuilder::buildExportCompletedBody(
            $export,
            'resources/product.export.completed',
            'resources/product.export.failed'
        );
    }
}
