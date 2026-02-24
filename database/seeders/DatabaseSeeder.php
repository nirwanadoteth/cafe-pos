<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->warn(PHP_EOL . 'Creating categories...');
        $categories = $this->withProgressBar(8, fn () => Category::factory(1)->create());
        $this->command->info('Categories created.');

        $this->command->warn(PHP_EOL . 'Creating products...');
        $products = $this->withProgressBar(13, fn () => Product::factory(1)
            ->sequence(fn ($sequence) => ['category_id' => $categories->random(1)->first()->id])
            ->create());
        $this->command->info('Products created.');

        $this->command->warn(PHP_EOL . 'Creating customers...');
        $customers = $this->withProgressBar(50, fn () => Customer::factory(1)->create());
        $this->command->info('Customers created.');

        $this->command->warn(PHP_EOL . 'Creating orders...');
        $orders = $this->withProgressBar(50, function () use ($customers, $products) {
            $itemCount = random_int(2, 5);
            // Pick unique products to avoid duplicate items per order
            $selectedProducts = $products->random(min($itemCount, $products->count()));

            return Order::factory(1)
                ->sequence(fn ($sequence) => ['customer_id' => $customers->random(1)->first()->id])
                ->has(Payment::factory()->count(1))
                ->has(
                    OrderItem::factory()
                        ->count($selectedProducts->count())
                        ->sequence(...$selectedProducts->map(fn (Product $product) => [
                            'product_id' => $product->id,
                            'unit_price' => $product->price,
                        ])->toArray()),
                    'items'
                )
                ->create();
        });
        $this->command->info('Orders created.');

        $this->call([
            ShieldSeeder::class,
        ]);
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection;

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
