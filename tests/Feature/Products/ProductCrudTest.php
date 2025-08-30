<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    public function test_can_create_product_and_slug_is_set(): void
    {
        $name = 'Test Latte';

        $product = Product::query()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => 'desc',
            'is_visible' => true,
            'price' => 12000,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'is_visible' => true,
        ]);
    }

    public function test_can_update_product_price_and_visibility(): void
    {
        $product = Product::factory()->create([
            'is_visible' => false,
            'price' => 10000,
        ]);

        $product->update([
            'is_visible' => true,
            'price' => 15000,
        ]);

        $this->assertSame(true, (bool) $product->fresh()->is_visible);
        $this->assertSame(15000.0, (float) $product->fresh()->price);
    }
}
