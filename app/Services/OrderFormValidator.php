<?php

namespace App\Services;

use App\Models\Product;

class OrderFormValidator
{
    /**
     * Validate that the items array contains at least one item with quantity > 0
     */
    public static function validateItemsArray(mixed $value): bool
    {
        if (! is_array($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ((int) ($item['qty'] ?? 0) > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validate that all items have sufficient stock
     */
    public static function validateInventoryAvailability(mixed $value): bool
    {
        if (! is_array($value)) {
            return true; // Let other validation handle array validation
        }

        $itemsWithQty = collect($value)
            ->filter(fn (array $item): bool => (int) ($item['qty'] ?? 0) > 0 && isset($item['product_id']));

        if ($itemsWithQty->isEmpty()) {
            return true;
        }

        // Single query to fetch all needed products at once instead of N+1
        $products = Product::query()
            ->whereIn('id', $itemsWithQty->pluck('product_id'))
            ->pluck('stock_quantity', 'id');

        foreach ($itemsWithQty as $item) {
            $stock = $products->get($item['product_id']);

            if ($stock !== null && $stock < (int) $item['qty']) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get validation error message for items
     */
    public static function getItemsValidationMessage(): string
    {
        return __('resources/order.validation.at_least_one_item');
    }

    /**
     * Get validation error message for inventory
     */
    public static function getInventoryValidationMessage(): string
    {
        return __('resources/order.validation.insufficient_stock');
    }
}
