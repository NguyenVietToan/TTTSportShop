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


    'facebook' => [
        'client_id' => '2141860202699939',
        'client_secret' => '68a9e38be890367f3a18fbbd948aae1e',
        'redirect' => 'https://localhost/TTTSportShop/SourceCode/auth/login/facebook/callback',
    ],

    'google' => [
        'client_id' => '692592894452-ol79fusrnh62ud8priof70mvj6mjknp3.apps.googleusercontent.com',
        'client_secret' => 'VVLZVV1aycyT77BeW0LBRAhF',
        'redirect' => 'https://localhost/TTTSportShop/SourceCode/auth/login/google/callback',
    ],

];
