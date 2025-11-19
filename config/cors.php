<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => array_filter(array_unique([
        env('FRONTEND_URL', 'http://localhost:5173'),
        'https://dargroupltd.com',
        'https://www.dargroupltd.com',
        parse_url(env('FRONTEND_URL', ''), PHP_URL_HOST) ? (parse_url(env('FRONTEND_URL'), PHP_URL_SCHEME) ?? 'https') . '://' . parse_url(env('FRONTEND_URL'), PHP_URL_HOST) : null,
        parse_url(env('APP_URL', ''), PHP_URL_HOST) ? (parse_url(env('APP_URL'), PHP_URL_SCHEME) ?? 'https') . '://' . parse_url(env('APP_URL'), PHP_URL_HOST) : null,
    ])),
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];

