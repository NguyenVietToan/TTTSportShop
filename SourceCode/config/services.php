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
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

/*
    'facebook' => [
        'client_id' => '259596271235378',
        'client_secret' => '6c4305aebaa502093c15a0ba18d0fa34',
        'redirect' => 'http://localhost:8080/CongDATN/auth/login/facebook/callback',
    ],

    'google' => [
        'client_id' => '1021682225877-kj0f0blsfpj3g7l70pf5717r6vo9514t.apps.googleusercontent.com',
        'client_secret' => 'HDznHYOutqxU4aaMAcI8xavG',
        'redirect' => 'http://localhost:8080/CongDATN/auth/login/google/callback',
    ],
*/

];
