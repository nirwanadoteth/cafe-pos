<?php

namespace App\Filament\Resources\Products\Widgets;

use App\Filament\Resources\Products\Pages\ListProducts;
use App\Models\Product;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class ProductStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListProducts::class;
    }

    protected function getStats(): array
    {
        // SQL: SELECT COUNT(*) FROM products
        $totalProducts = $this->getPageTableQuery()->count();
        // SQL: SELECT products.id, products.name, COUNT(order_item.id) AS items_count
        //      FROM products LEFT JOIN order_item ON order_item.product_id = products.id
        //      GROUP BY products.id ORDER BY items_count DESC LIMIT 1
        $favoriteProduct = $this->getPageTableQuery()
            ->select(['id', 'name'])
            ->withCount('items')
            ->orderBy('items_count', 'desc')
            ->first();
        // SQL: SELECT AVG(price) FROM products
        $averagePrice = round((float) $this->getPageTableQuery()->avg('price') / 100, precision: 2);

        return [
            Stat::make(__('resources/product.stat.total'), $totalProducts),
            Stat::make(
                __('resources/product.stat.favorite'),
                $favoriteProduct instanceof Product ? $favoriteProduct->name : 'N/A'
            ),
            Stat::make(
                __('resources/product.stat.avg_price'),
                Number::currency($averagePrice, 'IDR', 'id')
            ),
        ];
    }
}
