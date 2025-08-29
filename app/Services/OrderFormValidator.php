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
        if (is_array($value) === false) {
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
        if (is_array($value) === false) {
            return true; // Let other validation handle array validation
        }

        foreach ($value as $item) {
            $qty = (int) ($item['qty'] ?? 0);
            $productId = $item['product_id'] ?? null;

            if ($qty > 0 && $productId) {
                $product = Product::find($productId);
                if ($product && $product->stock_quantity < $qty) {
                    return false;
                }
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
