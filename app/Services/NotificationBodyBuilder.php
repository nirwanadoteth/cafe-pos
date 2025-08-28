<?php

namespace App\Services;

use Filament\Actions\Exports\Models\Export;
use Filament\Actions\Imports\Models\Import;

class NotificationBodyBuilder
{
    public static function buildImportCompletedBody(Import $import, string $completedMessageKey, string $failedMessageKey): string
    {
        return static::buildCompletedBody($import, $completedMessageKey, $failedMessageKey);
    }

    public static function buildExportCompletedBody(Export $export, string $completedMessageKey, string $failedMessageKey): string
    {
        return static::buildCompletedBody($export, $completedMessageKey, $failedMessageKey);
    }

    protected static function buildCompletedBody(Import | Export $processor, string $completedMessageKey, string $failedMessageKey): string
    {
        $body = __($completedMessageKey, [
            'count' => number_format($processor->successful_rows),
            'label' => str('row')->plural($processor->successful_rows),
        ]);

        $failedRowsCount = $processor->getFailedRowsCount();
        if ($failedRowsCount > 0) {
            $body .= ' ' . __($failedMessageKey, [
                'count' => number_format($failedRowsCount),
                'label' => str('row')->plural($failedRowsCount),
            ]);
        }

        return $body;
    }
}
