<?php

namespace Tests\Unit;

use App\DTOs\PaymentData;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\PaymentSettlementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PaymentSettlementServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create an order with a specific total price for testing
     */
    private function createOrderWithTotalPrice(float $totalPrice): Order
    {
        $order = Order::factory()->make();
        $order->total_price = $totalPrice;
        $order->saveQuietly(); // Skip events/observers
        return $order;
    }

    public function test_get_paid_amount_calculates_successful_payments_only(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 50.00, // Will be stored as 5000 cents via MoneyCast
            'status' => PaymentStatus::Successful->value,
        ]);
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 30.00, // Will be stored as 3000 cents via MoneyCast
            'status' => PaymentStatus::Successful->value,
        ]);
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 20.00, // Will be stored as 2000 cents via MoneyCast
            'status' => PaymentStatus::Failed->value,
        ]);

        $paidAmount = PaymentSettlementService::getPaidAmount($order);
        
        $this->assertEquals(8000, $paidAmount); // Only successful payments: 5000 + 3000 = 8000 cents
    }

    public function test_is_paid_returns_true_when_fully_paid(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 100.00,
            'status' => PaymentStatus::Successful->value,
        ]);

        $this->assertTrue(PaymentSettlementService::isPaid($order));
    }

    public function test_is_paid_returns_true_when_overpaid(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 120.00,
            'status' => PaymentStatus::Successful->value,
        ]);

        $this->assertTrue(PaymentSettlementService::isPaid($order));
    }

    public function test_is_paid_returns_false_when_underpaid(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 50.00,
            'status' => PaymentStatus::Successful->value,
        ]);

        $this->assertFalse(PaymentSettlementService::isPaid($order));
    }

    public function test_add_payment_creates_payment_successfully(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        
        $paymentData = new PaymentData(
            method: PaymentMethod::Cash,
            amount: 5000, // 50.00 in cents
            status: PaymentStatus::Successful,
            reference: 'REF123',
            meta: ['notes' => 'test payment']
        );

        $payment = PaymentSettlementService::addPayment($order, $paymentData);

        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertEquals($order->id, $payment->order_id);
        $this->assertEquals(50.00, $payment->amount); // MoneyCast converts back to dollars
        $this->assertEquals(PaymentMethod::Cash, $payment->method);
        $this->assertEquals(PaymentStatus::Successful, $payment->status);
        $this->assertEquals('REF123', $payment->reference);
        $this->assertEquals(['notes' => 'test payment'], $payment->meta);
    }

    public function test_add_payment_throws_exception_for_negative_amount(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        
        $paymentData = new PaymentData(
            method: PaymentMethod::Cash,
            amount: -100 // Negative cents
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Payment amount must be greater than zero.');

        PaymentSettlementService::addPayment($order, $paymentData);
    }

    public function test_add_payment_throws_exception_for_zero_amount(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        
        $paymentData = new PaymentData(
            method: PaymentMethod::Cash,
            amount: 0 // Zero cents
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Payment amount must be greater than zero.');

        PaymentSettlementService::addPayment($order, $paymentData);
    }

    public function test_get_remaining_amount_calculates_correctly(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 60.00, // Will be 6000 cents
            'status' => PaymentStatus::Successful->value,
        ]);

        $remaining = PaymentSettlementService::getRemainingAmount($order);
        
        $this->assertEquals(4000, $remaining); // 10000 - 6000 = 4000 cents
    }

    public function test_get_remaining_amount_returns_zero_when_overpaid(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 120.00, // Will be 12000 cents
            'status' => PaymentStatus::Successful->value,
        ]);

        $remaining = PaymentSettlementService::getRemainingAmount($order);
        
        $this->assertEquals(0, $remaining);
    }

    public function test_get_change_amount_calculates_correctly_when_overpaid(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 120.00, // Will be 12000 cents
            'status' => PaymentStatus::Successful->value,
        ]);

        $change = PaymentSettlementService::getChangeAmount($order);
        
        $this->assertEquals(2000, $change); // 12000 - 10000 = 2000 cents
    }

    public function test_get_change_amount_returns_zero_when_not_overpaid(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 80.00, // Will be 8000 cents
            'status' => PaymentStatus::Successful->value,
        ]);

        $change = PaymentSettlementService::getChangeAmount($order);
        
        $this->assertEquals(0, $change);
    }

    public function test_multiple_payment_methods_scenario(): void
    {
        // AC-001: Order with two payments (cash 50_000, card 25_000) for total 75_000 is paid
        $order = $this->createOrderWithTotalPrice(750.00); // 750.00 = 75000 cents
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 500.00, // 50000 cents
            'method' => PaymentMethod::Cash->value,
            'status' => PaymentStatus::Successful->value,
        ]);
        
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 250.00, // 25000 cents
            'method' => PaymentMethod::Card->value,
            'status' => PaymentStatus::Successful->value,
        ]);

        $this->assertTrue(PaymentSettlementService::isPaid($order));
        $this->assertEquals(75000, PaymentSettlementService::getPaidAmount($order));
        $this->assertEquals(0, PaymentSettlementService::getRemainingAmount($order));
    }
}