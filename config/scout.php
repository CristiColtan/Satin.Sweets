<?php

use App\Models\Addon;
use App\Models\Product;

return [
    'driver' => env('SCOUT_DRIVER', 'meilisearch'),

    'meilisearch' => [
        'host' => env('MEILISEARCH_HOST', 'http://127.0.0.1:7700'),
        'key' => env('MEILISEARCH_KEY', null),
    ],
    'index-settings' => [
        Product::class => [
            'typoTolerance' => [
                'enabled' => true,
                'minWordSizeForTypos' => [
                    'oneTypo' => 4,
                    'twoTypos' => 7
                ],
                'disableOnWords' => [],
                'disableOnAttributes' => []
            ],
            'searchableAttributes' => [
                'title',
                'description',
            ],
            'filterableAttributes' => [
                'category_id',
                'created_at',
                'updated_at',
            ],
            'sortableAttributes' => [
                'price',
                'created_at',
                'updated_at',
            ],
        ],
        Addon::class => [
            'typoTolerance' => [
                'enabled' => true,
                'minWordSizeForTypos' => [
                    'oneTypo' => 4,
                    'twoTypos' => 7
                ],
                'disableOnWords' => [],
                'disableOnAttributes' => []
            ],
            'searchableAttributes' => [
                'name',
                'description',
            ],
            'filterableAttributes' => [
                'type',
                'is_active',
                'created_at',
                'updated_at',
            ],
            'sortableAttributes' => [
                'price',
                'created_at',
                'updated_at',
            ],
        ]
    ]
];
