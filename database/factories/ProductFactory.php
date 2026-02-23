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

        $descriptions = [
            'Espresso' => 'A concentrated shot of pure coffee, brewed by forcing pressurised hot water through finely ground beans for an intense, bold flavour.',
            'Cappuccino' => 'A classic Italian espresso drink with a double shot of espresso and equal parts steamed milk and thick, velvety milk foam.',
            'Café Latte' => 'A smooth and creamy espresso-based drink made with rich espresso shots and steamed milk, topped with a light layer of foam.',
            'Americano' => 'A full-bodied espresso diluted with hot water, delivering a clean, smooth coffee flavour similar to a long black.',
            'Mocha' => 'A rich espresso-based drink blended with chocolate syrup and steamed milk, topped with whipped cream for an indulgent treat.',
            'Green Tea Latte' => 'A refreshing blend of earthy matcha green tea and velvety steamed milk, lightly sweetened for a perfectly balanced sip.',
            'Croissant' => 'A buttery, flaky French pastry baked to a golden crisp on the outside with a soft, airy interior. Best enjoyed fresh.',
            'Chocolate Muffin' => 'A moist, double-chocolate muffin packed with cocoa and chocolate chips, baked to rise with a perfectly domed top.',
            'Cheesecake' => 'A creamy, velvety New York-style cheesecake on a buttery biscuit base, served chilled with a light fruit compote.',
            'Iced Caramel Macchiato' => 'Layers of vanilla syrup, cold milk, and espresso poured over ice, finished with a golden caramel drizzle.',
            'Club Sandwich' => 'A classic triple-decker sandwich stacked with roasted chicken, crispy bacon, fresh lettuce, tomato, and mayo on toasted bread.',
            'Chicken Wrap' => 'A hearty grilled chicken wrap filled with crisp lettuce, fresh tomatoes, and a creamy sauce, all tucked in a soft tortilla.',
            'Chocolate Brownie' => 'A rich, fudgy brownie loaded with chunks of dark chocolate, baked to perfection with a crisp top and gooey centre.',
            'Bagel with Cream Cheese' => 'A toasted bagel slathered with smooth cream cheese — simple, satisfying, and perfect as a light breakfast or snack.',
            'Blueberry Scone' => 'A golden, crumbly scone bursting with fresh blueberries, lightly sweetened and best served warm with clotted cream.',
            'Pumpkin Spice Latte' => 'A seasonal favourite featuring bold espresso, warm pumpkin spice syrup, and steamed milk, crowned with whipped cream.',
            'Flat White' => 'A velvety espresso drink made with a double ristretto and a small amount of micro-foamed milk for an intense, smooth taste.',
            'Matcha Latte' => 'A vibrant, earthy latte crafted with ceremonial grade matcha whisked into steamed milk, naturally sweetened and calming.',
            'Chai Tea Latte' => 'A warming blend of black tea infused with aromatic spices — cinnamon, cardamom, and ginger — combined with steamed milk.',
            'Turkey Panini' => 'A toasted panini pressed with sliced turkey, melted Swiss cheese, fresh spinach, and a tangy cranberry spread.',
            'Ham and Cheese Croissant' => 'A flaky, buttery croissant filled with savory ham and melted cheese, baked until golden and irresistibly warm.',
            'Lemon Tart' => 'A crisp pastry shell filled with silky, tangy lemon curd and dusted with powdered sugar — a bright and zesty treat.',
            'Fruit Salad' => 'A refreshing medley of seasonal fresh fruits, lightly tossed in a honey-citrus dressing for a healthy and vibrant snack.',
            'Iced Matcha Latte' => 'Ceremonial grade matcha blended with cold milk and poured over ice — a refreshing, antioxidant-rich alternative to iced coffee.',
            'Vanilla Bean Frappuccino' => 'A sweet and creamy blended beverage featuring vanilla bean, milk, and ice, topped with whipped cream and a caramel drizzle.',
        ];

        return [
            'name' => $name = fake()->unique()->randomElement($products),
            'slug' => Str::slug($name),
            'description' => $descriptions[$name] ?? fake()->sentence(),
            'is_visible' => fake()->boolean(),
            'price' => fake()->numberBetween(25000, 75000),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'low_stock_threshold' => fake()->optional(0.7)->numberBetween(5, 20),
            'created_at' => fake()->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => fake()->dateTimeBetween('-5 month'),
        ];
    }
}
