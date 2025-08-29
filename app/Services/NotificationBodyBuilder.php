<?php

namespace App\Services;

use Filament\Actions\Exports\Models\Export;
use Filament\Actions\Imports\Models\Import;

class NotificationBodyBuilder
{
    /**
     * Build notification body for completed import
     *
     * @param  Import  $import  The import instance
     * @param  string  $completedMessageKey  Translation key for success message
     * @param  string  $failedMessageKey  Translation key for failure message
     * @return string Formatted notification body
     */
    public static function buildImportCompletedBody(Import $import, string $completedMessageKey, string $failedMessageKey): string
    {
        return static::buildCompletedBody($import, $completedMessageKey, $failedMessageKey);
    }

    /**
     * Build notification body for completed export
     *
     * @param  Export  $export  The export instance
     * @param  string  $completedMessageKey  Translation key for success message
     * @param  string  $failedMessageKey  Translation key for failure message
     * @return string Formatted notification body
     */
    public static function buildExportCompletedBody(Export $export, string $completedMessageKey, string $failedMessageKey): string
    {
        return static::buildCompletedBody($export, $completedMessageKey, $failedMessageKey);
    }

    /**
     * Build generic completion notification body
     *
     * @param  Import|Export  $processor  The import or export processor
     * @param  string  $completedMessageKey  Translation key for success message
     * @param  string  $failedMessageKey  Translation key for failure message
     * @return string Formatted notification body with success and failure counts
     */
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
