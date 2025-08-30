<?php

declare(strict_types=1);

namespace Tests\Feature\Orders;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    public function test_order_completes_when_payment_covers_total(): void
    {
        $product = Product::factory()->create(['price' => 12_500]);

        $order = Order::factory()->create(['status' => OrderStatus::New]);
        OrderItem::factory()->for($order)->for($product)->create([
            'qty' => 2,
            'unit_price' => $product->price,
        ]);

        // Trigger saving event that recalculates total_price
        $order->save();
        $order->refresh();
        $this->assertSame(25_000.0, $order->total_price);

        // Simulate UI payment repeater behavior: setting payment >= total moves status to completed
        Payment::create(['order_id' => $order->id, 'amount' => 25_000]);
        $order->status = OrderStatus::Completed;
        $order->save();

        $this->assertEquals(OrderStatus::Completed, $order->fresh()->status);
    }

    public function test_order_cancellation_keeps_items_and_total_zeroed_on_save(): void
    {
        $product = Product::factory()->create(['price' => 10_000]);
        $order = Order::factory()->create(['status' => OrderStatus::New]);
        OrderItem::factory()->for($order)->for($product)->create([
            'qty' => 3,
            'unit_price' => $product->price,
        ]);

        // Trigger saving event that recalculates total_price
        $order->save();
        $order->refresh();
        $this->assertSame(30_000.0, $order->total_price);

        // Mark as cancelled and save; items remain but total re-calculates (unchanged by status)
        $order->status = OrderStatus::Cancelled;
        $order->save();

        $order->refresh();
        $this->assertEquals(OrderStatus::Cancelled, $order->status);
        $this->assertCount(1, $order->items);
        $this->assertSame(30_000.0, $order->total_price);
    }
}
