<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use Tests\TestCase;

class OrderItemsCascadeTest extends TestCase
{
    public function test_soft_delete_does_not_delete_items(): void
    {
        $order = Order::factory()->create();
        $order->items()->createMany([
            ['qty' => 1, 'unit_price' => 1000],
            ['qty' => 2, 'unit_price' => 2000],
        ]);

        $this->assertDatabaseCount('order_item', 2);

        // Soft delete should NOT cascade to items (no soft deletes on items)
        $order->delete();
        $this->assertSoftDeleted('orders', ['id' => $order->id]);
        $this->assertDatabaseCount('order_item', 2);
    }

    public function test_force_delete_cascades_items(): void
    {
        $order = Order::factory()->create();
        $order->items()->createMany([
            ['qty' => 1, 'unit_price' => 1000],
            ['qty' => 2, 'unit_price' => 2000],
        ]);

        $this->assertDatabaseCount('order_item', 2);

        // Hard delete (force) should cascade to items via FK
        $order->forceDelete();

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
        $this->assertDatabaseCount('order_item', 0);
    }
}
