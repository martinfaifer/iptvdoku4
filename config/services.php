<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'api' => [
        'nanguTv' => [
            'url' => env('NANGU_URL'),
            'ssl_url' => env('NANGU_SSL_URL'),
            'ssl_key' => env('NANGU_SSL_KEY'),
            'isp_code' => env('NANGU_ISP_CODE'),
            'cert' => env('NANGU_CERT'),
            'pk' => env('NANGU_PK')
        ],
        'iptvDohled' => [
            'url' => env('IPTVDOHLED_URL'),
            'username' => env('IPTVDOHLED_USERNAME'),
            'password' => env('IPTVDOHLED_PASSWORD'),
        ],
        [
            'nms' => [
                'url' => env('NMS_URL'),
                'username' => env('NMS_USER'),
                'password' => env('NMS_PASSWORD'),
            ],
        ],
        [
            'epg' => [
                'url' => env('EPG_URL'),
                'key' => env('EPG_KEY'),
            ],
        ],
        [
            'nimble' => [
                'url' => env('NIMBLE_WMS_URL'),
                'api_key' => env('NIMBLE_WMS_API_KEY'),
                'client_id' => env('NIMBLE_WMS_API_CLIENT_ID'),
                'data_slice' => env('NIMBLE_WMS_DATA_SLICE'),
            ],
        ],
        [
            'open_weather_map' => [
                'url' => env('OPEN_WEATHER_MAP_URL'),
                'api_key' => env('OPEN_WEATHER_MAP_API_KEY')
            ]
        ],
        [
            'old_iptv_doku' => [
                'url' => env('OLD_IPTV_DOKU_URL'),
                'user' => env('OLD_IPTV_DOKU_USER'),
                'password' => env('OLD_IPTV_DOKU_PASSWORD')
            ]
        ]
    ],

];
