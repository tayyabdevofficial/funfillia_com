<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Blogger Admin API Base URL
    |--------------------------------------------------------------------------
    | The root endpoint for the backend API v1 (e.g. http://127.0.0.1:8000/api/v1)
    */
    'api_url' => rtrim(env('BLOGGER_API_URL', 'http://127.0.0.1:8000/api/v1'), '/'),

    /*
    |--------------------------------------------------------------------------
    | Website Authentication Credentials
    |--------------------------------------------------------------------------
    | Each website in the network has a dedicated API Key and Secret for
    | HMAC-SHA256 handshake verification and tamper-proof server-to-server calls.
    */
    'api_key' => env('BLOGGER_API_KEY', ''),
    'api_secret' => env('BLOGGER_API_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Registered Client Domain
    |--------------------------------------------------------------------------
    */
    'client_domain' => env('BLOGGER_CLIENT_DOMAIN', 'funfillia.com'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Settings
    |--------------------------------------------------------------------------
    */
    'timeout' => (int) env('BLOGGER_API_TIMEOUT', 10),
    'connect_timeout' => (int) env('BLOGGER_API_CONNECT_TIMEOUT', 5),

    /*
    |--------------------------------------------------------------------------
    | Data Caching Strategy
    |--------------------------------------------------------------------------
    | Cache server-to-server responses locally to eliminate duplicate API calls
    | and deliver sub-millisecond response times to visitors.
    */
    'cache_enabled' => (bool) env('BLOGGER_CACHE_ENABLED', true),
    'cache_ttl' => (int) env('BLOGGER_CACHE_TTL', 120), // seconds
    'categories_cache_ttl' => (int) env('BLOGGER_CATEGORIES_CACHE_TTL', 300),

    /*
    |--------------------------------------------------------------------------
    | Media Proxy Settings
    |--------------------------------------------------------------------------
    | Obfuscates storage URLs so users never see the backend admin domain or paths.
    */
    'media_cache_disk' => env('BLOGGER_MEDIA_DISK', 'local'),
];
