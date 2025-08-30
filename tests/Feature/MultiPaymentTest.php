<?php

namespace Tests\Feature;

use App\DTOs\PaymentData;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymentSettlementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiPaymentTest extends TestCase
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

    public function test_can_add_multiple_payments_to_order(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);

        // Add cash payment
        $cashPayment = PaymentSettlementService::addPayment($order, new PaymentData(
            method: PaymentMethod::Cash,
            amount: 6000, // 60.00
        ));

        // Add card payment
        $cardPayment = PaymentSettlementService::addPayment($order, new PaymentData(
            method: PaymentMethod::Card,
            amount: 4000, // 40.00
            reference: 'TXN123'
        ));

        $order->refresh();

        $this->assertCount(2, $order->payments);
        $this->assertTrue(PaymentSettlementService::isPaid($order));
        $this->assertEquals(10000, PaymentSettlementService::getPaidAmount($order)); // 100.00 in cents
    }

    public function test_acceptance_criteria_001_order_with_two_payments_is_paid(): void
    {
        // AC-001: Order with two payments (cash 50_000, card 25_000) for total 75_000 is paid
        $order = $this->createOrderWithTotalPrice(750.00); // 75000 cents

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

    public function test_acceptance_criteria_002_cash_overpayment_shows_change(): void
    {
        // AC-002: Cash payment larger than remaining amount displays change on invoice
        $order = $this->createOrderWithTotalPrice(75.00); // 7500 cents

        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 100.00, // 10000 cents
            'method' => PaymentMethod::Cash->value,
            'status' => PaymentStatus::Successful->value,
        ]);

        $changeAmount = PaymentSettlementService::getChangeAmount($order);
        $this->assertEquals(2500, $changeAmount); // 25.00 in cents change
        $this->assertTrue(PaymentSettlementService::isPaid($order));
    }

    public function test_acceptance_criteria_004_deleting_payment_updates_paid_status(): void
    {
        // AC-004: Deleting a payment updates paid status accordingly
        $order = $this->createOrderWithTotalPrice(100.00);

        $payment1 = Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 60.00,
            'method' => PaymentMethod::Cash->value,
            'status' => PaymentStatus::Successful->value,
        ]);

        $payment2 = Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 40.00,
            'method' => PaymentMethod::Card->value,
            'status' => PaymentStatus::Successful->value,
        ]);

        // Initially paid
        $this->assertTrue(PaymentSettlementService::isPaid($order));

        // Delete one payment
        $payment2->delete();

        // Now underpaid
        $this->assertFalse(PaymentSettlementService::isPaid($order));
        $this->assertEquals(6000, PaymentSettlementService::getPaidAmount($order)); // Only 60.00 left
        $this->assertEquals(4000, PaymentSettlementService::getRemainingAmount($order)); // 40.00 remaining
    }

    public function test_acceptance_criteria_005_validation_prevents_negative_amounts(): void
    {
        // AC-005: Validation prevents negative amounts and rejects unknown methods
        $order = $this->createOrderWithTotalPrice(100.00);

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        PaymentSettlementService::addPayment($order, new PaymentData(
            method: PaymentMethod::Cash,
            amount: -1000 // Negative amount
        ));
    }

    public function test_mixed_payment_statuses_only_successful_counted(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);

        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 50.00,
            'status' => PaymentStatus::Successful->value,
        ]);

        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 30.00,
            'status' => PaymentStatus::Pending->value,
        ]);

        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 20.00,
            'status' => PaymentStatus::Failed->value,
        ]);

        // Only successful payment should count
        $this->assertFalse(PaymentSettlementService::isPaid($order));
        $this->assertEquals(5000, PaymentSettlementService::getPaidAmount($order)); // Only 50.00
        $this->assertEquals(5000, PaymentSettlementService::getRemainingAmount($order)); // 50.00 remaining
    }

    public function test_backward_compatibility_with_existing_single_payment(): void
    {
        // Test that existing orders with the old single payment still work
        $order = $this->createOrderWithTotalPrice(100.00);

        // Create a payment the old way (single payment)
        $payment = Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 100.00,
            'method' => PaymentMethod::Cash->value, // Will default to cash via migration
            'status' => PaymentStatus::Successful->value, // Will default to successful via migration
        ]);

        // Should work with both old payment() and new payments() relationships
        $this->assertEquals($payment->id, $order->payment->id);
        $this->assertCount(1, $order->payments);
        $this->assertEquals($payment->id, $order->payments->first()->id);

        // Settlement service should work correctly
        $this->assertTrue(PaymentSettlementService::isPaid($order));
        $this->assertEquals(10000, PaymentSettlementService::getPaidAmount($order)); // 100.00 in cents
        $this->assertEquals(0, PaymentSettlementService::getRemainingAmount($order));
    }

    public function test_invoice_template_renders_with_multiple_payments(): void
    {
        $order = $this->createOrderWithTotalPrice(100.00);
        $order->customer()->associate(\App\Models\Customer::factory()->create());
        $order->save();

        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 60.00,
            'method' => PaymentMethod::Cash->value,
            'status' => PaymentStatus::Successful->value,
            'reference' => null,
        ]);

        Payment::factory()->create([
            'order_id' => $order->id,
            'amount' => 50.00,
            'method' => PaymentMethod::Card->value,
            'status' => PaymentStatus::Successful->value,
            'reference' => 'TXN12345',
        ]);

        // Test that the invoice template can render without errors
        $html = view('invoice', ['order' => $order])->render();

        $this->assertStringContainsString('PAYMENTS', $html);
        $this->assertStringContainsString('CASH', $html);
        $this->assertStringContainsString('CARD', $html);
        $this->assertStringContainsString('TXN12345', $html);
        $this->assertStringContainsString('TOTAL PAID', $html);
        $this->assertStringContainsString('CHANGE', $html); // Should show change since overpaid
    }
}
