<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Site Identity & Branding
    |--------------------------------------------------------------------------
    | Centralized settings for white-labeling and fast template cloning.
    */
    'name' => env('SITE_NAME', 'Funfillia'),
    'tagline' => env('SITE_TAGLINE', 'Your Ultimate Destination for Fun Quizzes, Pop Culture & Viral Stories'),
    'domain' => env('SITE_DOMAIN', 'funfillia.com'),
    'url' => env('APP_URL', 'https://funfillia.com'),
    'logo_light' => env('SITE_LOGO_LIGHT', '/images/logo.png'),
    'logo_dark' => env('SITE_LOGO_DARK', '/images/logo-dark.png'),
    'favicon' => env('SITE_FAVICON', '/favicon.png'),
    'theme_color' => env('SITE_THEME_COLOR', '#6366f1'),
    'contact_email' => env('SITE_CONTACT_EMAIL', 'hello@funfillia.com'),

    /*
    |--------------------------------------------------------------------------
    | Social Profile URLs
    |--------------------------------------------------------------------------
    */
    'social' => [
        'twitter' => env('SOCIAL_TWITTER', 'https://twitter.com/funfillia'),
        'facebook' => env('SOCIAL_FACEBOOK', 'https://facebook.com/funfillia'),
        'instagram' => env('SOCIAL_INSTAGRAM', 'https://instagram.com/funfillia'),
        'pinterest' => env('SOCIAL_PINTEREST', 'https://pinterest.com/funfillia'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Fallback OpenGraph & SEO Metadata
    |--------------------------------------------------------------------------
    */
    'seo' => [
        'default_image' => env('SEO_DEFAULT_IMAGE', '/images/og-default.jpg'),
        'twitter_handle' => env('SEO_TWITTER_HANDLE', '@funfillia'),
        'locale' => 'en_US',
    ],
];
