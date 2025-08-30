<?php

namespace App\DTOs;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;

readonly class PaymentData
{
    /**
     * Constructor
     *
     * @param  PaymentMethod  $method  Payment method
     * @param  int  $amount  Amount in cents
     * @param  PaymentStatus  $status  Payment status
     * @param  string|null  $reference  Optional payment reference
     * @param  array<string, mixed>|null  $meta  Optional metadata
     */
    public function __construct(
        public PaymentMethod $method,
        public int $amount, // Amount in cents
        public PaymentStatus $status = PaymentStatus::Successful,
        public ?string $reference = null,
        public ?array $meta = null,
    ) {}

    /**
     * Create PaymentData from array
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            method: PaymentMethod::from($data['method']),
            amount: (int) $data['amount'], // Expect amount in cents
            status: isset($data['status']) ? PaymentStatus::from($data['status']) : PaymentStatus::Successful,
            reference: $data['reference'] ?? null,
            meta: $data['meta'] ?? null,
        );
    }

    /**
     * Convert to array for model creation (amount will be converted to dollars by MoneyCast)
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'method' => $this->method->value,
            'amount' => $this->amount / 100, // Convert cents to dollars for MoneyCast
            'status' => $this->status->value,
            'reference' => $this->reference,
            'meta' => $this->meta,
        ];
    }
}
