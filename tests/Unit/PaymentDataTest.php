<?php

namespace Tests\Unit;

use App\DTOs\PaymentData;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Tests\TestCase;

class PaymentDataTest extends TestCase
{
    public function test_can_create_payment_data_with_all_fields(): void
    {
        $paymentData = new PaymentData(
            method: PaymentMethod::Card,
            amount: 10000,
            status: PaymentStatus::Successful,
            reference: 'TXN123',
            meta: ['gateway' => 'stripe']
        );

        $this->assertEquals(PaymentMethod::Card, $paymentData->method);
        $this->assertEquals(10000, $paymentData->amount);
        $this->assertEquals(PaymentStatus::Successful, $paymentData->status);
        $this->assertEquals('TXN123', $paymentData->reference);
        $this->assertEquals(['gateway' => 'stripe'], $paymentData->meta);
    }

    public function test_can_create_payment_data_with_defaults(): void
    {
        $paymentData = new PaymentData(
            method: PaymentMethod::Cash,
            amount: 5000
        );

        $this->assertEquals(PaymentMethod::Cash, $paymentData->method);
        $this->assertEquals(5000, $paymentData->amount);
        $this->assertEquals(PaymentStatus::Successful, $paymentData->status);
        $this->assertNull($paymentData->reference);
        $this->assertNull($paymentData->meta);
    }

    public function test_can_create_from_array(): void
    {
        $data = [
            'method' => 'card',
            'amount' => 15000,
            'status' => 'pending',
            'reference' => 'REF456',
            'meta' => ['bank' => 'BCA'],
        ];

        $paymentData = PaymentData::fromArray($data);

        $this->assertEquals(PaymentMethod::Card, $paymentData->method);
        $this->assertEquals(15000, $paymentData->amount);
        $this->assertEquals(PaymentStatus::Pending, $paymentData->status);
        $this->assertEquals('REF456', $paymentData->reference);
        $this->assertEquals(['bank' => 'BCA'], $paymentData->meta);
    }

    public function test_can_create_from_array_with_defaults(): void
    {
        $data = [
            'method' => 'cash',
            'amount' => 8000,
        ];

        $paymentData = PaymentData::fromArray($data);

        $this->assertEquals(PaymentMethod::Cash, $paymentData->method);
        $this->assertEquals(8000, $paymentData->amount);
        $this->assertEquals(PaymentStatus::Successful, $paymentData->status);
        $this->assertNull($paymentData->reference);
        $this->assertNull($paymentData->meta);
    }

    public function test_can_convert_to_array(): void
    {
        $paymentData = new PaymentData(
            method: PaymentMethod::Ewallet,
            amount: 20000,
            status: PaymentStatus::Successful,
            reference: 'EWALLET789',
            meta: ['wallet' => 'GoPay']
        );

        $array = $paymentData->toArray();

        $expectedArray = [
            'method' => 'ewallet',
            'amount' => 200.00, // Converted from 20000 cents to dollars
            'status' => 'successful',
            'reference' => 'EWALLET789',
            'meta' => ['wallet' => 'GoPay'],
        ];

        $this->assertEquals($expectedArray, $array);
    }

    public function test_to_array_handles_nulls(): void
    {
        $paymentData = new PaymentData(
            method: PaymentMethod::Cash,
            amount: 5000
        );

        $array = $paymentData->toArray();

        $expectedArray = [
            'method' => 'cash',
            'amount' => 50.00, // Converted from 5000 cents to dollars
            'status' => 'successful',
            'reference' => null,
            'meta' => null,
        ];

        $this->assertEquals($expectedArray, $array);
    }
}
