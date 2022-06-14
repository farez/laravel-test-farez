<?php

return [
    'profit_margin' => env('COFFEE_PROFIT_MARGIN', 0.25),
    'shipping_cost' => env('COFFEE_SHIPPING_COST', 10.00),
    'products' => [
        'gold_coffee' => [
          'label' => 'Gold coffee',
          'margin' => 0.25,
        ],
        'arabic_coffee' => [
            'label' => 'Arabic coffee',
            'margin' => 0.15,
        ]
    ],
];
