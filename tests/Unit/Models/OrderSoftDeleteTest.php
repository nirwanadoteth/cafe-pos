<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use Tests\TestCase;

class OrderSoftDeleteTest extends TestCase
{
    public function test_soft_delete_and_restore_order(): void
    {
        $order = Order::factory()->create();

        $order->delete();
        $this->assertSoftDeleted('orders', ['id' => $order->id]);

        $order->restore();
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'deleted_at' => null]);
    }
}
