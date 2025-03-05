<?php

return [
    'enabled' => env('RETRIEVER_SERVICES_ENABLED', true),
    'access-token' => [
        'url' => env('RETRIEVER_SERVICES_ACCESS_TOKEN_URL', 'https://example.com/token'),
        'key' => env('RETRIEVER_SERVICES_ACCESS_TOKEN_KEY', 'api_access_token_key'),
        'secret' => env('RETRIEVER_SERVICES_ACCESS_TOKEN_SECRET', 'api_access_token_secret'),
        'cache' => [
            'key' => 'retriever-services:access-token',
            'ttl' => 60 * 60 * 24,
        ],
    ],
    'ai' => [
        'url' => env('RETRIEVER_SERVICES_AI_URL', 'https://example.com/api'),
    ],
];