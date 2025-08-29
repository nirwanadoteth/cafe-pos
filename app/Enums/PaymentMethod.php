<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasColor, HasIcon, HasLabel
{
    case Cash = 'cash';

    case Card = 'card';

    case Ewallet = 'ewallet';

    case BankTransfer = 'bank_transfer';

    public function getLabel(): string
    {
        return match ($this) {
            self::Cash => 'Cash',
            self::Card => 'Card',
            self::Ewallet => 'E-Wallet',
            self::BankTransfer => 'Bank Transfer',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Cash => 'success',
            self::Card => 'info',
            self::Ewallet => 'warning',
            self::BankTransfer => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Cash => 'heroicon-m-banknotes',
            self::Card => 'heroicon-m-credit-card',
            self::Ewallet => 'heroicon-m-device-phone-mobile',
            self::BankTransfer => 'heroicon-m-building-library',
        };
    }
}