<?php

return [
    'category' => [
        'single' => 'Category',
        'plural' => 'Categories',
        'nav.group' => 'Catalog',

        // Form labels
        'name' => 'Name',
        'slug' => 'Slug',
        'is_visible' => 'Visible to customers',
        'description' => 'Description',
        'created_at' => 'Created At',
        'updated_at' => 'Last Modified At',
        'no_description' => 'No description provided.',
        'visibility' => 'Visibility',
        'total_products' => 'Total Products',

        // Import/Export
        'import.completed' => 'Your category import has completed and :count :label imported.',
        'import.failed' => ':count :label failed to import.',
        'export.completed' => 'Your category export has completed and :count :label exported.',
        'export.failed' => ':count :label failed to export.',

        'import.columns' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'is_visible' => 'Visible',
        ],

        'import.examples' => [
            'name' => 'Category A',
            'slug' => 'category-a',
            'description' => 'This is the description for Category A',
            'is_visible' => 'yes',
        ],
    ],
    'order' => [
        'single' => 'Order',
        'plural' => 'Orders',
        'nav.group' => 'Transactions',

        // Form labels
        'number' => 'Number',
        'customer' => 'Customer',
        'customer.name' => 'Name',
        'status' => 'Status',
        'total' => 'Total',
        'created_at' => 'Created At',
        'updated_at' => 'Last Modified At',
        'details' => 'Order Details',
        'items' => 'Order Items',
        'date' => 'Order Date',
        'notes' => 'Notes',
        'cash' => 'Cash',

        // Actions
        'actions' => [
            'reset' => 'Reset',
            'pdf' => 'PDF',
            'create_customer' => 'Create customer',
            'add_payment' => 'Add payment',
        ],

        // Messages
        'messages' => [
            'reset_confirmation' => 'Are you sure?',
            'reset_description' => 'All existing items will be removed from the order.',
        ],

        // Item related
        'item' => [
            'product' => 'Product',
            'quantity' => 'Quantity',
            'unit_price' => 'Price',
            'increase' => 'Increase',
            'decrease' => 'Decrease',
            'reset_qty' => 'Reset quantity',
            'open_product' => 'Open product',
        ],

        // Filters
        'filters' => [
            'created_from' => 'Order from',
            'created_until' => 'Order until',
        ],

        'notifications' => [
            'new' => [
                'title' => 'New order',
                'body' => ':customer ordered :count products.',
            ],
        ],

        'stat' => [
            'orders' => 'Orders',
            'open_orders' => 'Open orders',
            'avg_price' => 'Average price',
        ],

        'tabs' => [
            'all' => 'All',
            'new' => 'New',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ],
    ],
    'product' => [
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
        'created_at' => 'Created At',
        'updated_at' => 'Last Modified At',

        // Help texts
        'visibility_help' => 'This product will be hidden from all sales channels.',

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
        ],

        'import.examples' => [
            'category' => 'Category A',
            'name' => 'Product A',
            'slug' => 'product-a',
            'description' => 'This is the description for Product A',
            'is_visible' => 'yes',
            'price' => 10000,
        ],
    ],
    'user' => [
        'single' => 'User',
        'plural' => 'Users',
        'nav.group' => 'Access Control',

        // Form labels
        'name' => 'Name',
        'email' => 'Email address',
        'password' => 'Password',
        'new_password' => 'New Password',
        'password_confirmation' => 'Confirm Password',
        'new_password_confirmation' => 'Confirm New Password',
        'verified' => 'Verified',
        'unverified' => 'Unverified',
        'roles' => 'Roles',
        'created_at' => 'Join Date',
    ],
];
