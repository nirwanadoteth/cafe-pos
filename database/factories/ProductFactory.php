<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            'Espresso',
            'Cappuccino',
            'Café Latte',
            'Americano',
            'Mocha',
            'Green Tea Latte',
            'Croissant',
            'Chocolate Muffin',
            'Cheesecake',
            'Iced Caramel Macchiato',
            'Club Sandwich',
            'Chicken Wrap',
            'Chocolate Brownie',
            'Bagel with Cream Cheese',
            'Blueberry Scone',
            'Pumpkin Spice Latte',
            'Flat White',
            'Matcha Latte',
            'Chai Tea Latte',
            'Turkey Panini',
            'Ham and Cheese Croissant',
            'Lemon Tart',
            'Fruit Salad',
            'Iced Matcha Latte',
            'Vanilla Bean Frappuccino',
        ];

        return [
            'name' => $name = fake()->unique()->randomElement($products),
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'is_visible' => fake()->boolean(),
            'price' => fake()->numberBetween(25000, 75000),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'low_stock_threshold' => fake()->optional(0.7)->numberBetween(5, 20),
            'created_at' => fake()->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => fake()->dateTimeBetween('-5 month'),
        ];
    }
}
