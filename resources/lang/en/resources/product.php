<?php

return [

    'single' => 'Product',
    'plural' => 'Products',
    'nav.group' => 'Catalog',

    // Labels
    'name' => 'Name',
    'slug' => 'Slug',
    'images' => 'Images',
    'pricing' => 'Pricing',
    'price' => 'Price',
    'status' => 'Status',
    'visible' => 'Visible',
    'description' => 'Description',
    'associations' => 'Associations',
    'category' => 'Category',
    'image' => 'Image',
    'visibility' => 'Visibility',
    'inventory' => 'Inventory',
    'stock_quantity' => 'Stock Quantity',
    'low_stock_threshold' => 'Low Stock Threshold',
    'low_stock' => '(Low Stock)',
    'created_at' => 'Created At',
    'updated_at' => 'Last Modified At',

    // Help texts
    'visibility_help' => 'This product will be hidden from all sales channels.',
    'low_stock_threshold_help' => 'When stock quantity falls to or below this number, the product will be highlighted as low stock.',

    // Placeholders
    'no_images' => 'No images provided.',
    'no_description' => 'No description provided.',

    // Widget labels
    'stat.total' => 'Total products',
    'stat.favorite' => 'Favorite product',
    'stat.avg_price' => 'Average price',

    // Import/Export
    'import.completed' => 'Your product import has completed and :count :label imported.',
    'import.failed' => ':count :label failed to import.',
    'export.completed' => 'Your product export has completed and :count :label exported.',
    'export.failed' => ':count :label failed to export.',

    'import.columns' => [
        'category' => 'Category',
        'name' => 'Name',
        'slug' => 'Slug',
        'description' => 'Description',
        'is_visible' => 'Visible',
        'price' => 'Price',
        'stock_quantity' => 'Stock Quantity',
        'low_stock_threshold' => 'Low Stock Threshold',
    ],

    'import.examples' => [
        'category' => 'Category A',
        'name' => 'Product A',
        'slug' => 'product-a',
        'description' => 'This is the description for Product A',
        'is_visible' => 'yes',
        'price' => 10000,
        'stock_quantity' => 100,
        'low_stock_threshold' => 10,
    ],

];
