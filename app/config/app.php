<?php
/**
 * Application configuration.
 * Values come from .env via App\Core\Env; this file is the single source of truth
 * for non-secret settings.
 */
return [
    'name'      => env('APP_NAME', 'Vastu Anand Real Estate'),
    'env'       => env('APP_ENV', 'production'),
    'debug'     => filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOL),
    'url'       => rtrim(env('APP_URL', 'http://localhost:8000'), '/'),
    'timezone'  => env('APP_TIMEZONE', 'Asia/Kolkata'),
    'key'       => env('APP_KEY', ''),

    'brand' => [
        'legal_name'   => 'VastuAnand Real Estate',
        'short_name'   => 'Vastu Anand',
        'tagline'      => 'Curated Luxury & Investment-Ready Properties in Mumbai',
        'description'  => 'Mumbai\'s trusted real estate partner for transparent, insight-led property decisions across Bandra, Powai, BKC, Juhu, Thane & Navi Mumbai.',
        'phone'        => '+91 9876543210',
        'phone_alt'    => '+91 9876543210',
        'whatsapp'     => '919876543210',
        'email'        => 'info@vastuanandm.com',
        'email_alt'    => 'sales@vastuanandm.com',
        'address'      => [
            'Mumbai, Maharashtra, India',
            'Kalyan (W), Maharashtra',
            'Amravati, Maharashtra',
        ],
        'rera'         => 'A51900012345',  // placeholder
        'gst'          => '27ABCDE1234F1Z5',
        'years'        => '4+',
        'social' => [
            'facebook'  => 'https://facebook.com/vastuanand',
            'instagram' => 'https://instagram.com/vastuanand',
            'linkedin'  => 'https://linkedin.com/company/vastuanand',
            'twitter'   => 'https://twitter.com/vastuanand',
            'youtube'   => 'https://youtube.com/@vastuanand',
        ],
        'colors' => [
            'gold'      => '#C9A35B',
            'gold_dark' => '#8B6F30',
            'ink'       => '#0A0A0A',
            'graphite'  => '#161616',
            'pearl'     => '#F5F2EC',
        ],
    ],

    'pagination' => [
        'per_page' => 12,
    ],

    'recaptcha' => [
        'site'   => env('RECAPTCHA_SITE_KEY', ''),
        'secret' => env('RECAPTCHA_SECRET', ''),
    ],

    'maps' => [
        'google_key' => env('GOOGLE_MAPS_KEY', ''),
    ],
];
