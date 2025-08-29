<?php

namespace App\Services;

use App\DTOs\PaymentData;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Validation\ValidationException;

class PaymentSettlementService
{
    /**
     * Get the total paid amount for an order from successful payments
     *
     * @param Order $order The order to check
     * @return int Total paid amount in cents
     */
    public static function getPaidAmount(Order $order): int
    {
        // Query sum() returns raw DB values (already in cents)
        return $order->payments()
            ->where('status', PaymentStatus::Successful->value)
            ->sum('amount');
    }

    /**
     * Check if an order is fully paid
     *
     * @param Order $order The order to check
     * @return bool True if order is paid in full
     */
    public static function isPaid(Order $order): bool
    {
        $paidAmount = static::getPaidAmount($order); // In cents
        $totalPrice = (int) round($order->total_price * 100); // Convert dollars to cents
        
        return $paidAmount >= $totalPrice;
    }

    /**
     * Add a payment to an order with validation
     *
     * @param Order $order The order to add payment to
     * @param PaymentData $paymentData Payment data to add
     * @return Payment The created payment
     * @throws ValidationException If validation fails
     */
    public static function addPayment(Order $order, PaymentData $paymentData): Payment
    {
        // Validate payment amount
        if ($paymentData->amount <= 0) {
            throw ValidationException::withMessages([
                'amount' => 'Payment amount must be greater than zero.',
            ]);
        }

        // Validate amount doesn't exceed safe integer limits (in dollars)
        if ($paymentData->amount > PHP_INT_MAX / 10000) {
            throw ValidationException::withMessages([
                'amount' => 'Payment amount exceeds maximum allowed value.',
            ]);
        }

        // Sanitize reference if provided
        $reference = static::sanitizeReference($paymentData->reference);
        
        // Create payment data array with sanitized reference
        $paymentArray = $paymentData->toArray();
        $paymentArray['reference'] = $reference;
        
        // Create payment using the sanitized data
        return $order->payments()->create($paymentArray);
    }

    /**
     * Get remaining amount to be paid for an order
     *
     * @param Order $order The order to check
     * @return int Remaining amount in cents (0 if overpaid)
     */
    public static function getRemainingAmount(Order $order): int
    {
        $totalPrice = (int) round($order->total_price * 100); // Convert dollars to cents
        $paidAmount = static::getPaidAmount($order); // Already in cents
        
        return max(0, $totalPrice - $paidAmount);
    }

    /**
     * Get change amount for cash payments
     *
     * @param Order $order The order to check
     * @return int Change amount in cents (0 if not overpaid)
     */
    public static function getChangeAmount(Order $order): int
    {
        $totalPrice = (int) round($order->total_price * 100); // Convert dollars to cents
        $paidAmount = static::getPaidAmount($order); // Already in cents
        
        return max(0, $paidAmount - $totalPrice);
    }

    /**
     * Sanitize payment reference to prevent sensitive data leakage
     *
     * @param string|null $reference Raw reference
     * @return string|null Sanitized reference
     */
    private static function sanitizeReference(?string $reference): ?string
    {
        if ($reference === null) {
            return null;
        }

        // Remove any potential PAN/CVV data and limit length
        $sanitized = preg_replace('/\d{13,19}/', '****', $reference);
        $sanitized = preg_replace('/\b\d{3,4}\b/', '***', $sanitized);
        
        return substr($sanitized, 0, 191); // Respect database column limit
    }
}