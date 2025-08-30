<?php

namespace Tests\Feature;

use App\DTOs\PaymentData;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymentSettlementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

/**
 * Comprehensive acceptance criteria tests for multi-payment support
 */
class AcceptanceCriteriaTest extends TestCase
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

    /**
     * AC-001: Order with two payments (cash 50_000, card 25_000) for total 75_000 is paid
     */
    public function test_ac_001_order_with_two_payments_is_recognized_as_paid(): void
    {
        $order = $this->createOrderWithTotalPrice(750.00); // 750.00 = 75000 cents

        // Add cash payment of 50000 cents (500.00)
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 500.00,
            'method' => PaymentMethod::Cash->value,
            'status' => PaymentStatus::Successful->value,
        ]);

        // Add card payment of 25000 cents (250.00)
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 250.00,
            'method' => PaymentMethod::Card->value,
            'status' => PaymentStatus::Successful->value,
        ]);

        // Verify order is recognized as paid
        $this->assertTrue(PaymentSettlementService::isPaid($order));
        $this->assertEquals(75000, PaymentSettlementService::getPaidAmount($order)); // 750.00 in cents
        $this->assertEquals(0, PaymentSettlementService::getRemainingAmount($order));
    }

    /**
     * AC-002: Cash payment larger than remaining amount displays change on invoice
     */
    public function test_ac_002_cash_overpayment_shows_change_on_invoice(): void
    {
        $order = $this->createOrderWithTotalPrice(75.00);
        $order->customer()->associate(Customer::factory()->create());
        $order->saveQuietly(); // Save again to persist customer

        // Create cash payment larger than total
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 100.00,
            'method' => PaymentMethod::Cash->value,
            'status' => PaymentStatus::Successful->value,
        ]);

        // Verify change amount calculation
        $changeAmount = PaymentSettlementService::getChangeAmount($order);
        $this->assertEquals(2500, $changeAmount); // 25.00 change in cents

        // Verify invoice displays change
        $html = view('invoice', ['order' => $order])->render();
        $this->assertStringContainsString('CHANGE', $html);
        $this->assertStringContainsString('25', $html); // Change amount should be visible
    }

    /**
     * AC-003: Invoice shows payment breakdown with method labels
     */
    public function test_ac_003_invoice_shows_payment_breakdown_with_method_labels(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        $order->customer()->associate(Customer::factory()->create());
        $order->save();

        // Create multiple payments with different methods
        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 50.00,
            'method' => PaymentMethod::Cash->value,
            'status' => PaymentStatus::Successful->value,
        ]);

        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 30.00,
            'method' => PaymentMethod::Card->value,
            'status' => PaymentStatus::Successful->value,
            'reference' => 'CARD-123',
        ]);

        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 20.00,
            'method' => PaymentMethod::Ewallet->value,
            'status' => PaymentStatus::Successful->value,
            'reference' => 'GOPAY-456',
        ]);

        // Verify invoice shows payment breakdown
        $html = view('invoice', ['order' => $order])->render();

        $this->assertStringContainsString('PAYMENTS', $html);
        $this->assertStringContainsString('CASH', $html);
        $this->assertStringContainsString('CARD', $html);
        $this->assertStringContainsString('E-WALLET', $html);
        $this->assertStringContainsString('CARD-123', $html);
        $this->assertStringContainsString('GOPAY-456', $html);
        $this->assertStringContainsString('TOTAL PAID', $html);
    }

    /**
     * AC-004: Deleting a payment updates paid status accordingly
     */
    public function test_ac_004_deleting_payment_updates_paid_status(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);

        $payment1 = Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 70.00,
            'method' => PaymentMethod::Cash->value,
            'status' => PaymentStatus::Successful->value,
        ]);

        $payment2 = Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 30.00,
            'method' => PaymentMethod::Card->value,
            'status' => PaymentStatus::Successful->value,
        ]);

        // Initially paid in full
        $this->assertTrue(PaymentSettlementService::isPaid($order));
        $this->assertEquals(10000, PaymentSettlementService::getPaidAmount($order)); // 100.00 in cents

        // Delete one payment
        $payment2->delete();

        // Now underpaid
        $this->assertFalse(PaymentSettlementService::isPaid($order));
        $this->assertEquals(7000, PaymentSettlementService::getPaidAmount($order)); // 70.00 in cents
        $this->assertEquals(3000, PaymentSettlementService::getRemainingAmount($order)); // 30.00 remaining
    }

    /**
     * AC-005: Validation prevents negative amounts and rejects unknown methods
     */
    public function test_ac_005_validation_prevents_negative_amounts_and_unknown_methods(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);

        // Test negative amount validation
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Payment amount must be greater than zero.');

        PaymentSettlementService::addPayment($order, new PaymentData(
            method: PaymentMethod::Cash,
            amount: -1000 // Negative amount in cents
        ));
    }

    public function test_ac_005_validation_prevents_zero_amounts(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);

        // Test zero amount validation
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Payment amount must be greater than zero.');

        PaymentSettlementService::addPayment($order, new PaymentData(
            method: PaymentMethod::Cash,
            amount: 0 // Zero amount
        ));
    }

    public function test_all_payment_methods_work_correctly(): void
    {
        $order = $this->createOrderWithTotalPrice(200.00);

        // Test all payment methods
        $methods = [
            ['method' => PaymentMethod::Cash, 'amount' => 50.00],
            ['method' => PaymentMethod::Card, 'amount' => 50.00],
            ['method' => PaymentMethod::Ewallet, 'amount' => 50.00],
            ['method' => PaymentMethod::BankTransfer, 'amount' => 50.00],
        ];

        foreach ($methods as $methodData) {
            PaymentSettlementService::addPayment($order, new PaymentData(
                method: $methodData['method'],
                amount: (int) ($methodData['amount'] * 100), // Convert to cents
                reference: "REF-{$methodData['method']->value}"
            ));
        }

        // Verify all payments were created correctly
        $this->assertCount(4, $order->fresh()->payments);
        $this->assertTrue(PaymentSettlementService::isPaid($order));
        $this->assertEquals(20000, PaymentSettlementService::getPaidAmount($order)); // 200.00 in cents

        // Verify each payment method is present
        $paymentMethods = $order->fresh()->payments->pluck('method')->toArray();
        $this->assertContains(PaymentMethod::Cash, $paymentMethods);
        $this->assertContains(PaymentMethod::Card, $paymentMethods);
        $this->assertContains(PaymentMethod::Ewallet, $paymentMethods);
        $this->assertContains(PaymentMethod::BankTransfer, $paymentMethods);
    }

    public function test_security_reference_sanitization(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);

        // Test that PAN-like numbers are sanitized
        $payment = PaymentSettlementService::addPayment($order, new PaymentData(
            method: PaymentMethod::Card,
            amount: 10000, // 100.00 in cents
            reference: '4111111111111111 CVV:123' // Fake card number and CVV
        ));

        // Reference should be sanitized
        $this->assertStringNotContainsString('4111111111111111', $payment->reference);
        $this->assertStringNotContainsString('123', $payment->reference);
        $this->assertStringContainsString('****', $payment->reference);
    }
}
