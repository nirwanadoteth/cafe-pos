<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Hot Coffee',
            'Iced Coffee',
            'Tea',
            'Pastries',
            'Sandwiches',
            'Desserts',
            'Snacks',
            'Non-Coffee Beverages',
            'Breakfast',
            'Lunch',
            'Dinner',
            'Seasonal Specials',
            'Vegan Options',
            'Gluten-Free Options',
        ];

        $descriptions = [
            'Hot Coffee' => 'A curated selection of expertly brewed hot coffees, from bold espressos to smooth lattes — the perfect warm cup for any occasion.',
            'Iced Coffee' => 'Chilled coffee beverages for a refreshing boost — from iced lattes and cold brews to frappes and blended espresso drinks.',
            'Tea' => 'A thoughtfully curated selection of hot and iced teas, from classic black and green teas to fragrant herbal and spiced blends.',
            'Pastries' => 'Freshly baked pastries crafted daily, including buttery croissants, flaky danishes, and soft muffins — perfect with any coffee.',
            'Sandwiches' => 'Freshly prepared sandwiches and wraps packed with quality ingredients, ideal for a satisfying lunch or a quick bite on the go.',
            'Desserts' => 'Indulgent sweet treats to satisfy your cravings — from rich brownies and creamy cheesecakes to delicate tarts and scones.',
            'Snacks' => 'Bite-sized savoury and sweet snacks to keep you going between meals. Great for a quick pick-me-up alongside your favourite drink.',
            'Non-Coffee Beverages' => 'Refreshing non-coffee beverages including fruit teas, matcha lattes, smoothies, and more — something delicious for every preference.',
            'Breakfast' => 'Start your morning right with our hearty breakfast offerings, from freshly baked pastries to savoury wraps and bagels.',
            'Lunch' => 'A satisfying midday menu featuring fresh sandwiches, hearty wraps, and light bites to fuel your afternoon.',
            'Dinner' => 'Satisfying dinner plates and hearty bites perfect for winding down the day with comfort food and a relaxing ambience.',
            'Seasonal Specials' => 'Limited-time offerings inspired by the season — unique flavours and ingredients available for a short time only.',
            'Vegan Options' => 'Delicious plant-based options crafted with care, offering flavourful vegan drinks and bites without compromising on taste.',
            'Gluten-Free Options' => 'A thoughtful selection of gluten-free drinks and food items, so everyone can enjoy something delicious without worry.',
        ];

        return [
            'name' => $name = fake()->unique()->randomElement($categories),
            'slug' => Str::slug($name),
            'description' => $descriptions[$name] ?? fake()->sentence(),
            'is_visible' => fake()->boolean(),
            'created_at' => fake()->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => fake()->dateTimeBetween('-5 month'),
        ];
    }
}
