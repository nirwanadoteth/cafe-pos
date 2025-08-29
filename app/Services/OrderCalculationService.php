<?php

namespace App\Services;

use App\Models\Order;

class OrderCalculationService
{
    /**
     * Calculate total price for an order based on its items
     *
     * @param  Order  $order  The order to calculate total for
     * @return float The calculated total price
     */
    public static function calculateTotalPrice(Order $order): float
    {
        return (float) $order->items()
            ->selectRaw('COALESCE(SUM(qty * unit_price), 0) as total')
            ->value('total');
    }

    /**
     * Handle order deletion cleanup
     *
     * @param  Order  $order  The order being deleted
     */
    public static function handleOrderDeletion(Order $order): void
    {
        // Delete all payments associated with this order
        $order->payments()->delete();
    }
}
