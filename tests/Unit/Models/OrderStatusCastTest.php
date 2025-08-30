<?php

namespace Tests\Unit\Models;

use App\Enums\OrderStatus;
use App\Models\Order;
use Tests\TestCase;

class OrderStatusCastTest extends TestCase
{
    public function test_status_is_cast_to_enum(): void
    {
        $order = Order::factory()->create(['status' => 'new']);

        $this->assertInstanceOf(OrderStatus::class, $order->status);
        $this->assertSame(OrderStatus::New, $order->status);

        $order->update(['status' => 'completed']);
        $order->refresh();
        $this->assertSame(OrderStatus::Completed, $order->status);
    }
}
