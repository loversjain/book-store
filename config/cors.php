<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Options
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for handling CORS requests. This
    | package supports all the common CORS methods, you can configure them
    | here. If you're unsure about this configuration, the defaults should
    | be sufficient for most applications.
    |
    */

    'paths' => ['api/*', '/login', '/logout'], // Adjust the paths as needed

    'allowed_methods' => ['*'], // You can restrict to specific methods like GET, POST, PUT, etc.

    'allowed_origins' => ['*'], // You can restrict to specific domains

    'allowed_headers' => ['*'], // Or limit to specific headers like Content-Type, X-Requested-With, etc.

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];
