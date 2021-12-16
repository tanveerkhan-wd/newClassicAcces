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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google' => [
        'client_id' => '455962763344-d2ii32gs6l4lmn99834cesnhbk6etnc3.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://dubaievisa.in/auth/google/callback',
    ],
    'facebook' => [
        'client_id' => '971650170361417',
        'client_secret' => 'c539e13308fdf1096b111a5159e50465',
        'redirect' => 'https://dubaievisa.in/auth/facebook/callback',
    ],

];
