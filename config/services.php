<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    /*'stripe' => [
        'model' => App\User::class,
        'key' => .env('STRIPE_KEY'),
        'secret' => .env('STRIPE_SECRET'),
    ],*/

    'turbo' => [
        'login' => env('TURBOSMS_LOGIN'),
        'password' => env('TURBOSMS_PASSWORD'),
        'sender' => env('TURBOSMS_SENDER')
    ],

    'eSputnik' => [
        'login' => env('ESPUTNIK_LOGIN'),
        'password' => env('ESPUTNIK_PASSWORD'),
        'sender' => env('ESPUTNIK_SENDER')
    ],

    'smsRu' => [
        'login' => env('SMSRU_LOGIN'),
        'password' => env('SMSRU_PASSWORD'),
    ],

    'sendpulse' => [
        'user_id' => env('SENDPULSE_USER_ID'),
        'secret' => env('SENDPULSE_SECRET'),
        'sender' => env('SENDPULSE_SENDER'),
        'transliterate' => env('SENDPULSE_TRANSLITERATE'),
    ],
    // Available tools : "sociable" (default), "hybridauth"
    'socials-login-tools' => 'sociable',
];
