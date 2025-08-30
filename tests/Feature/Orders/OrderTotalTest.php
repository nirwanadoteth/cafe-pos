<?php

namespace Tests\Feature\Orders;

use App\Models\Order;
use Tests\TestCase;

class OrderTotalTest extends TestCase
{
    public function test_total_price_is_recalculated_from_items_on_save(): void
    {
        $order = Order::factory()->create(['total_price' => 0]);

        // Add items (product_id is nullable in the model)
        $order->items()->create([
            'qty' => 2,
            'unit_price' => 10000,
        ]);
        $order->items()->create([
            'qty' => 3,
            'unit_price' => 5000,
        ]);

        // Trigger model saving hook to recalculate total
        $order->notes = 'recalculate';
        $order->save();

        $order->refresh();

        // Expected: (2*10000) + (3*5000) = 20000 + 15000 = 35000
        $this->assertSame(35000.0, (float) $order->total_price);
    }
}
