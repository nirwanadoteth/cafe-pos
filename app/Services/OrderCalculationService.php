<?php

namespace App\Services;

use App\Models\Order;

class OrderCalculationService
{
    /**
     * Calculate total price for an order based on its items
     */
    public static function calculateTotalPrice(Order $order): float
    {
        return (float) $order->items()
            ->selectRaw('COALESCE(SUM(qty * unit_price), 0) as total')
            ->value('total');
    }

    /**
     * Handle order deletion cleanup
     */
    public static function handleOrderDeletion(Order $order): void
    {
        $order->payment()->delete();
    }
}
