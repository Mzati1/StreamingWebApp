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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'tmdb' => [
        'base_url' => env('TMDB_BASE_URL'),
        'token' => env('TMDB_TOKEN'),
        'image_base_url' => env('TMDB_IMAGE_BASE_URL')
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'socials' => [
        'twitter' => env('SOCIALS_TWITTER'),
        'instagram' => env('SOCIALS_INSTAGRAM'),
        'whatsapp' => env('SOCIALS_WHATSAPP'),
        'discord' => env('SOCIALS_DISCORD'),
        'facebook' => env('SOCIALS_FACEBOOK'),
        'youtube' => env('SOCIALS_YOUTUBE')
    ],
];
