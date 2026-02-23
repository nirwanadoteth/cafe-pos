<?php

return [
    'title' => 'Reports',

    'product' => [
        'title' => 'Product Reports',

        'table' => [
            'columns' => [
                'ordered' => 'Ordered',
                'revenue' => 'Revenue',
            ],

            'summary' => [
                'least' => 'Least ordered product',
                'most' => 'Most ordered product',
                'total_ordered' => 'Total ordered quantity',
                'total_revenue' => 'Total revenue',
            ],
        ],
    ],

    'sales' => [
        'title' => 'Sales Reports',

        'table' => [
            'columns' => [
                'ordered' => 'Ordered',
                'total_price' => 'Total',
                'order_date' => 'Order Date',
            ],

            'summary' => [
                'min' => 'Min',
                'max' => 'Max',
                'sum' => 'Sum',
                'avg' => 'Avg',
            ],
        ],
    ],
];
