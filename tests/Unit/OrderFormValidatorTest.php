<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\OrderFormValidator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFormValidatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_validates_inventory_availability_passes_when_stock_sufficient(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);

        $items = [
            [
                'product_id' => $product->id,
                'qty' => 5,
            ]
        ];

        $this->assertTrue(OrderFormValidator::validateInventoryAvailability($items));
    }

    public function test_validates_inventory_availability_fails_when_insufficient_stock(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 2]);

        $items = [
            [
                'product_id' => $product->id,
                'qty' => 5,
            ]
        ];

        $this->assertFalse(OrderFormValidator::validateInventoryAvailability($items));
    }

    public function test_validates_inventory_availability_handles_mixed_products(): void
    {
        $product1 = Product::factory()->create(['stock_quantity' => 10]);
        $product2 = Product::factory()->create(['stock_quantity' => 2]);

        $items = [
            [
                'product_id' => $product1->id,
                'qty' => 5,
            ],
            [
                'product_id' => $product2->id,
                'qty' => 3, // This should fail
            ]
        ];

        $this->assertFalse(OrderFormValidator::validateInventoryAvailability($items));
    }

    public function test_validates_inventory_availability_ignores_zero_quantity(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 0]);

        $items = [
            [
                'product_id' => $product->id,
                'qty' => 0,
            ]
        ];

        $this->assertTrue(OrderFormValidator::validateInventoryAvailability($items));
    }
}