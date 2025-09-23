<?php

return [
    'driver' => env('SCOUT_DRIVER', 'meilisearch'),

    'meilisearch' => [
        'host' => env('MEILISEARCH_HOST', 'http://127.0.0.1:7700'),
        'key' => env('MEILISEARCH_KEY', null),
    ],
    'index-settings' => [
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
    ]
];
