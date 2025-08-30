<?php

namespace Tests\Unit;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Tests\TestCase;

class PaymentEnumsTest extends TestCase
{
    public function test_payment_method_enum_values(): void
    {
        $this->assertEquals('cash', PaymentMethod::Cash->value);
        $this->assertEquals('card', PaymentMethod::Card->value);
        $this->assertEquals('ewallet', PaymentMethod::Ewallet->value);
        $this->assertEquals('bank_transfer', PaymentMethod::BankTransfer->value);
    }

    public function test_payment_method_labels(): void
    {
        $this->assertEquals('Cash', PaymentMethod::Cash->getLabel());
        $this->assertEquals('Card', PaymentMethod::Card->getLabel());
        $this->assertEquals('E-Wallet', PaymentMethod::Ewallet->getLabel());
        $this->assertEquals('Bank Transfer', PaymentMethod::BankTransfer->getLabel());
    }

    public function test_payment_method_colors(): void
    {
        $this->assertEquals('success', PaymentMethod::Cash->getColor());
        $this->assertEquals('info', PaymentMethod::Card->getColor());
        $this->assertEquals('warning', PaymentMethod::Ewallet->getColor());
        $this->assertEquals('gray', PaymentMethod::BankTransfer->getColor());
    }

    public function test_payment_method_icons(): void
    {
        $this->assertEquals('heroicon-m-banknotes', PaymentMethod::Cash->getIcon());
        $this->assertEquals('heroicon-m-credit-card', PaymentMethod::Card->getIcon());
        $this->assertEquals('heroicon-m-device-phone-mobile', PaymentMethod::Ewallet->getIcon());
        $this->assertEquals('heroicon-m-building-library', PaymentMethod::BankTransfer->getIcon());
    }

    public function test_payment_status_enum_values(): void
    {
        $this->assertEquals('successful', PaymentStatus::Successful->value);
        $this->assertEquals('pending', PaymentStatus::Pending->value);
        $this->assertEquals('failed', PaymentStatus::Failed->value);
        $this->assertEquals('cancelled', PaymentStatus::Cancelled->value);
    }

    public function test_payment_status_labels(): void
    {
        $this->assertEquals('Successful', PaymentStatus::Successful->getLabel());
        $this->assertEquals('Pending', PaymentStatus::Pending->getLabel());
        $this->assertEquals('Failed', PaymentStatus::Failed->getLabel());
        $this->assertEquals('Cancelled', PaymentStatus::Cancelled->getLabel());
    }

    public function test_payment_status_colors(): void
    {
        $this->assertEquals('success', PaymentStatus::Successful->getColor());
        $this->assertEquals('warning', PaymentStatus::Pending->getColor());
        $this->assertEquals('danger', PaymentStatus::Failed->getColor());
        $this->assertEquals('gray', PaymentStatus::Cancelled->getColor());
    }

    public function test_payment_status_icons(): void
    {
        $this->assertEquals('heroicon-m-check-circle', PaymentStatus::Successful->getIcon());
        $this->assertEquals('heroicon-m-clock', PaymentStatus::Pending->getIcon());
        $this->assertEquals('heroicon-m-x-circle', PaymentStatus::Failed->getIcon());
        $this->assertEquals('heroicon-m-no-symbol', PaymentStatus::Cancelled->getIcon());
    }
}
