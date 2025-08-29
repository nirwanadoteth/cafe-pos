<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween(25000, 300000),
            'method' => fake()->randomElement(PaymentMethod::cases())->value,
            'status' => PaymentStatus::Successful->value,
            'reference' => fake()->optional(0.3)->regexify('[A-Z0-9]{8,12}'),
            'meta' => fake()->optional(0.2)->randomElement([
                ['gateway' => 'stripe', 'transaction_id' => fake()->uuid()],
                ['bank' => 'BCA', 'account_number' => '****' . fake()->numberBetween(1000, 9999)],
                ['wallet' => 'GoPay', 'phone' => '+62***' . fake()->numberBetween(1000000, 9999999)],
                null,
            ]),
            'created_at' => fake()->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => fake()->dateTimeBetween('-5 month'),
        ];
    }

    /**
     * Make a cash payment
     */
    public function cash(): static
    {
        return $this->state(fn (array $attributes) => [
            'method' => PaymentMethod::Cash->value,
            'reference' => null,
            'meta' => null,
        ]);
    }

    /**
     * Make a card payment
     */
    public function card(): static
    {
        return $this->state(fn (array $attributes) => [
            'method' => PaymentMethod::Card->value,
            'reference' => fake()->regexify('[A-Z0-9]{10,15}'),
            'meta' => ['gateway' => 'stripe', 'last4' => fake()->numberBetween(1000, 9999)],
        ]);
    }

    /**
     * Make an e-wallet payment
     */
    public function ewallet(): static
    {
        return $this->state(fn (array $attributes) => [
            'method' => PaymentMethod::Ewallet->value,
            'reference' => fake()->regexify('[A-Z0-9]{8,12}'),
            'meta' => ['wallet' => fake()->randomElement(['GoPay', 'OVO', 'DANA'])],
        ]);
    }

    /**
     * Make a pending payment
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentStatus::Pending->value,
        ]);
    }

    /**
     * Make a failed payment
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentStatus::Failed->value,
        ]);
    }
}
