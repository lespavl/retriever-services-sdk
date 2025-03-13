<?php

return [
    'enabled' => env('RETRIEVER_SERVICES_ENABLED', true),
    'access-token' => [
        'url' => env('RETRIEVER_AUTH_URL', 'https://example.com/token'),
        'key' => env('RETRIEVER_AUTH_KEY', 'api_access_token_key'),
        'secret' => env('RETRIEVER_AUTH_SECRET', 'api_access_token_secret'),
        'cache' => [
            'key' => 'retriever-services:access-token',
            'ttl' => 60 * 60 * 24,
        ],
    ],
    'ai' => [
        'url' => env('RETRIEVER_SERVICES_URL', 'https://example.com/api'),
    ],
];