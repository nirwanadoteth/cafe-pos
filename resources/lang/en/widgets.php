<?php

return [
    'customers-chart' => [
        'heading' => 'Total Customers',

        'datasets' => [
            'label' => 'Customers',
        ],

        'labels' => [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ],
    ],
    'latest-orders' => [
        'heading' => 'Latest Orders',

        'column' => [

            'created_at' => [
                'label' => 'Order Date',
            ],

            'number' => [
                'label' => 'Number',
            ],

            'customer' => [
                'label' => 'Customer',
            ],

            'status' => [
                'label' => 'Status',
            ],

            'total_price' => [
                'label' => 'Total Price',
            ],

        ],

        'action' => [

            'edit' => [
                'label' => 'Edit',
            ],

        ],
    ],
    'orders-chart' => [
        'heading' => 'Orders per month',

        'datasets' => [
            'label' => 'Orders',
        ],

        'labels' => [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ],
    ],
    'stats-overview' => [
        'stats' => [

            'revenue' => [
                'title' => 'Revenue',
            ],

            'new_customers' => [
                'title' => 'New customers',
            ],

            'new_orders' => [
                'title' => 'New orders',
            ],

        ],

        'trend' => [
            'increase' => 'increase',
            'decrease' => 'decrease',
        ],
    ],
];
