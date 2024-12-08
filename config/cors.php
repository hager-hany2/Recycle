<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */
    //to remove cors error



    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],//Allows to define header(post,GET,PUT,DELETE) options to send request Authorization

    'allowed_origins' => [
        'http://localhost:4200',
        'https://rasclny.vercel.app',
    ],
    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type,X-Auth-Token,Origin,Authorization'],// allow send for example json

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];

