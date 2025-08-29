<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryService
{
    /**
     * Ensure sufficient stock is available for a product
     *
     * @param  Product  $product  The product to check stock for
     * @param  int  $qty  The quantity requested
     *
     * @throws ValidationException When insufficient stock is available
     */
    public static function ensureSufficientStock(Product $product, int $qty): void
    {
        if ($qty <= 0) {
            return;
        }

        if ($product->stock_quantity < $qty) {
            throw ValidationException::withMessages([
                'qty' => __('Insufficient stock. Available: :available, Requested: :requested', [
                    'available' => $product->stock_quantity,
                    'requested' => $qty,
                ]),
            ]);
        }
    }

    /**
     * Adjust stock quantities based on order status changes
     *
     * @param  Order  $order  The order that has been saved/updated
     */
    public static function adjustForOrderSaved(Order $order): void
    {
        if ($order->isDirty('status')) {
            $oldStatus = $order->getOriginal('status');
            // If oldStatus is already an OrderStatus enum, use it directly
            // If it's a string, convert it to enum
            $oldStatusEnum = $oldStatus instanceof OrderStatus ? $oldStatus :
                            ($oldStatus ? OrderStatus::from($oldStatus) : null);
            $newStatus = $order->status;

            static::handleStatusChange($order, $oldStatusEnum, $newStatus);
        }
    }

    /**
     * Handle stock adjustments when order status changes
     *
     * @param  Order  $order  The order
     * @param  OrderStatus|null  $oldStatus  Previous status
     * @param  OrderStatus  $newStatus  New status
     */
    protected static function handleStatusChange(Order $order, ?OrderStatus $oldStatus, OrderStatus $newStatus): void
    {
        // Deduct stock when moving to Processing or Completed
        if (in_array($newStatus, [OrderStatus::Processing, OrderStatus::Completed]) &&
            ! in_array($oldStatus, [OrderStatus::Processing, OrderStatus::Completed])) {
            static::deductStock($order);
        }

        // Restore stock when moving to Cancelled from Processing or Completed
        if ($newStatus === OrderStatus::Cancelled &&
            in_array($oldStatus, [OrderStatus::Processing, OrderStatus::Completed])) {
            static::restoreStock($order);
        }
    }

    /**
     * Deduct stock quantities for order items
     *
     * @param  Order  $order  The order to deduct stock for
     */
    protected static function deductStock(Order $order): void
    {
        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    // Use decrement for atomic operation with race condition protection
                    $item->product->decrement('stock_quantity', $item->qty);
                }
            }
        });
    }

    /**
     * Restore stock quantities for order items
     *
     * @param  Order  $order  The order to restore stock for
     */
    protected static function restoreStock(Order $order): void
    {
        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    // Use increment for atomic operation
                    $item->product->increment('stock_quantity', $item->qty);
                }
            }
        });
    }

    /**
     * Handle stock adjustments when order items are edited
     *
     * @param  Order  $order  The order being updated
     * @param  array<string, mixed>  $newItems  New item data
     * @param  array<string, mixed>  $oldItems  Old item data
     */
    public static function adjustForOrderItemChanges(Order $order, array $newItems, array $oldItems): void
    {
        // Only adjust stock if order is in Processing or Completed status
        if (! in_array($order->status, [OrderStatus::Processing, OrderStatus::Completed])) {
            return;
        }

        // Group items by product_id for comparison
        $newItemsByProduct = collect($newItems)->groupBy('product_id');
        $oldItemsByProduct = collect($oldItems)->groupBy('product_id');

        $allProductIds = $newItemsByProduct->keys()->merge($oldItemsByProduct->keys())->unique();

        DB::transaction(function () use ($allProductIds, $newItemsByProduct, $oldItemsByProduct) {
            foreach ($allProductIds as $productId) {
                $newQty = $newItemsByProduct->get($productId, collect())->sum('qty');
                $oldQty = $oldItemsByProduct->get($productId, collect())->sum('qty');

                $delta = $newQty - $oldQty;

                if ($delta !== 0) {
                    $product = Product::find($productId);
                    if ($product) {
                        // Negative delta means stock should be reduced (more items ordered)
                        // Positive delta means stock should be increased (fewer items ordered)
                        $product->increment('stock_quantity', -$delta);
                    }
                }
            }
        });
    }
}
