<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_low_stock_returns_true_when_stock_is_at_threshold(): void
    {
        $product = Product::factory()->create([
            'stock_quantity' => 5,
            'low_stock_threshold' => 5,
        ]);

        $this->assertTrue($product->isLowStock());
    }

    public function test_is_low_stock_returns_true_when_stock_is_below_threshold(): void
    {
        $product = Product::factory()->create([
            'stock_quantity' => 3,
            'low_stock_threshold' => 5,
        ]);

        $this->assertTrue($product->isLowStock());
    }

    public function test_is_low_stock_returns_false_when_stock_is_above_threshold(): void
    {
        $product = Product::factory()->create([
            'stock_quantity' => 10,
            'low_stock_threshold' => 5,
        ]);

        $this->assertFalse($product->isLowStock());
    }

    public function test_is_low_stock_returns_false_when_no_threshold_is_set(): void
    {
        $product = Product::factory()->create([
            'stock_quantity' => 0,
            'low_stock_threshold' => null,
        ]);

        $this->assertFalse($product->isLowStock());
    }
}
