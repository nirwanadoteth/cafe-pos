<?php

namespace Tests\Unit;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class InventoryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_ensure_sufficient_stock_passes_when_stock_is_available(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);

        // Should not throw exception
        InventoryService::ensureSufficientStock($product, 5);

        $this->assertTrue(true); // Test passes if no exception thrown
    }

    public function test_ensure_sufficient_stock_throws_exception_when_insufficient_stock(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 2]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Insufficient stock. Available: 2, Requested: 3');

        InventoryService::ensureSufficientStock($product, 3);
    }

    public function test_ensure_sufficient_stock_allows_zero_or_negative_quantity(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 0]);

        // Should not throw exception for zero or negative quantities
        InventoryService::ensureSufficientStock($product, 0);
        InventoryService::ensureSufficientStock($product, -1);

        $this->assertTrue(true);
    }

    public function test_adjust_for_order_saved_deducts_stock_when_moving_to_processing(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);
        $order = Order::factory()->create(['status' => OrderStatus::New]);
        $order->items()->create([
            'product_id' => $product->id,
            'qty' => 3,
            'unit_price' => 1000,
        ]);

        // Simulate status change to Processing
        $order->status = OrderStatus::Processing;
        $order->save();

        $product->refresh();
        $this->assertEquals(7, $product->stock_quantity);
    }

    public function test_adjust_for_order_saved_deducts_stock_when_moving_to_completed(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);
        $order = Order::factory()->create(['status' => OrderStatus::New]);
        $order->items()->create([
            'product_id' => $product->id,
            'qty' => 3,
            'unit_price' => 1000,
        ]);

        // Simulate status change to Completed
        $order->status = OrderStatus::Completed;
        $order->save();

        $product->refresh();
        $this->assertEquals(7, $product->stock_quantity);
    }

    public function test_adjust_for_order_saved_restores_stock_when_cancelled(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);
        $order = Order::factory()->create(['status' => OrderStatus::New]);
        $order->items()->create([
            'product_id' => $product->id,
            'qty' => 3,
            'unit_price' => 1000,
        ]);

        // Move to Processing first (this should deduct stock)
        $order->status = OrderStatus::Processing;
        $order->save();

        // Stock should be at 7 after Processing status
        $product->refresh();
        $this->assertEquals(7, $product->stock_quantity);

        // Cancel the order
        $order->status = OrderStatus::Cancelled;
        $order->save();

        $product->refresh();
        $this->assertEquals(10, $product->stock_quantity);
    }

    public function test_adjust_for_order_saved_does_not_change_stock_for_new_orders(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);
        $order = Order::factory()->create(['status' => OrderStatus::New]);
        $order->items()->create([
            'product_id' => $product->id,
            'qty' => 3,
            'unit_price' => 1000,
        ]);

        // Stock should remain unchanged for New orders
        $product->refresh();
        $this->assertEquals(10, $product->stock_quantity);
    }

    public function test_adjust_for_order_saved_does_not_double_deduct_when_moving_from_processing_to_completed(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);
        $order = Order::factory()->create(['status' => OrderStatus::New]);
        $order->items()->create([
            'product_id' => $product->id,
            'qty' => 3,
            'unit_price' => 1000,
        ]);

        // Move to Processing first
        $order->status = OrderStatus::Processing;
        $order->save();

        // Stock should be at 7 after Processing status
        $product->refresh();
        $this->assertEquals(7, $product->stock_quantity);

        // Move to Completed - should not deduct again
        $order->status = OrderStatus::Completed;
        $order->save();

        $product->refresh();
        $this->assertEquals(7, $product->stock_quantity);
    }
}
