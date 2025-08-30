<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasColor, HasIcon, HasLabel
{
    case Successful = 'successful';

    case Pending = 'pending';

    case Failed = 'failed';

    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Successful => 'Successful',
            self::Pending => 'Pending',
            self::Failed => 'Failed',
            self::Cancelled => 'Cancelled',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Successful => 'success',
            self::Pending => 'warning',
            self::Failed => 'danger',
            self::Cancelled => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Successful => 'heroicon-m-check-circle',
            self::Pending => 'heroicon-m-clock',
            self::Failed => 'heroicon-m-x-circle',
            self::Cancelled => 'heroicon-m-no-symbol',
        };
    }
}
