<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTrackingTest extends TestCase
{
    use RefreshDatabase;

    /** @test AC-001: Given a product with stock 5, When an order with qty 3 is completed, Then stock becomes 2. */
    public function test_stock_decreases_when_order_is_completed(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 5]);
        $customer = Customer::factory()->create();

        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => OrderStatus::New,
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'qty' => 3,
            'unit_price' => 1000,
        ]);

        // Complete the order
        $order->update(['status' => OrderStatus::Completed]);

        $product->refresh();
        $this->assertEquals(2, $product->stock_quantity);
    }

    /** @test AC-002: Given stock 2, When user attempts qty 3, Then validation error is shown and order not saved. */
    public function test_validation_prevents_overselling(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 2]);

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        \App\Services\InventoryService::ensureSufficientStock($product, 3);
    }

    /** @test AC-003: Given completed order qty 2, When order is cancelled, Then product stock increases by 2. */
    public function test_stock_restores_when_order_is_cancelled(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);
        $customer = Customer::factory()->create();

        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => OrderStatus::New,
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'qty' => 2,
            'unit_price' => 1000,
        ]);

        // Complete the order first (this should deduct stock)
        $order->update(['status' => OrderStatus::Completed]);

        // Stock should be reduced to 8
        $product->refresh();
        $this->assertEquals(8, $product->stock_quantity);

        // Cancel the order
        $order->update(['status' => OrderStatus::Cancelled]);

        $product->refresh();
        $this->assertEquals(10, $product->stock_quantity);
    }

    /** @test AC-004: Given item qty changes from 1 to 4, When saved, Then stock delta -3 is applied. */
    public function test_stock_adjusts_for_quantity_changes(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);
        $customer = Customer::factory()->create();

        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => OrderStatus::New,
        ]);

        $orderItem = $order->items()->create([
            'product_id' => $product->id,
            'qty' => 1,
            'unit_price' => 1000,
        ]);

        // Move to Processing to trigger stock deduction
        $order->update(['status' => OrderStatus::Processing]);

        // Stock should be reduced to 9
        $product->refresh();
        $this->assertEquals(9, $product->stock_quantity);

        // Capture old items before update
        $oldItems = [
            [
                'product_id' => $product->id,
                'qty' => 1,
            ],
        ];

        // Update the quantity
        $orderItem->update(['qty' => 4]);

        // Create new items structure
        $newItems = [
            [
                'product_id' => $product->id,
                'qty' => 4,
            ],
        ];

        \App\Services\InventoryService::adjustForOrderItemChanges($order, $newItems, $oldItems);

        // Stock should be reduced by additional 3 (9 - 3 = 6)
        $product->refresh();
        $this->assertEquals(6, $product->stock_quantity);
    }

    /** @test AC-005: UI shows low-stock badge when stock_quantity <= low_stock_threshold. */
    public function test_product_detects_low_stock_condition(): void
    {
        $product = Product::factory()->create([
            'stock_quantity' => 3,
            'low_stock_threshold' => 5,
        ]);

        $this->assertTrue($product->isLowStock());
    }

    public function test_stock_not_affected_by_new_orders(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);
        $customer = Customer::factory()->create();

        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => OrderStatus::New,
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'qty' => 3,
            'unit_price' => 1000,
        ]);

        // Stock should remain unchanged for New orders
        $product->refresh();
        $this->assertEquals(10, $product->stock_quantity);
    }

    public function test_stock_deducts_when_moved_to_processing(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);
        $customer = Customer::factory()->create();

        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => OrderStatus::New,
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'qty' => 3,
            'unit_price' => 1000,
        ]);

        // Move to Processing
        $order->update(['status' => OrderStatus::Processing]);

        $product->refresh();
        $this->assertEquals(7, $product->stock_quantity);
    }

    public function test_multiple_products_in_single_order(): void
    {
        $product1 = Product::factory()->create(['stock_quantity' => 10]);
        $product2 = Product::factory()->create(['stock_quantity' => 5]);
        $customer = Customer::factory()->create();

        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => OrderStatus::New,
        ]);

        $order->items()->create([
            'product_id' => $product1->id,
            'qty' => 2,
            'unit_price' => 1000,
        ]);

        $order->items()->create([
            'product_id' => $product2->id,
            'qty' => 1,
            'unit_price' => 2000,
        ]);

        // Complete the order
        $order->update(['status' => OrderStatus::Completed]);

        $product1->refresh();
        $product2->refresh();

        $this->assertEquals(8, $product1->stock_quantity);
        $this->assertEquals(4, $product2->stock_quantity);
    }
}
