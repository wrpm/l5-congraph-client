<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Congraph API URL
    |--------------------------------------------------------------------------
    |
    | URL for Congraph API, including sufix /api or /api/delivery
    |
    */

    'api_url' => env('CG_API_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | Pages Href
    |--------------------------------------------------------------------------
    |
    | url for getting all entities that should have url
    |
    */

    'pages_href' => env('CG_PAGES_HREF', ''),


    /*
    |--------------------------------------------------------------------------
    | Use Cache
    |--------------------------------------------------------------------------
    |
    | url for getting all entities that should have url
    |
    */

    'use_cache' => env('CG_USE_CACHE', true),


    /*
    |--------------------------------------------------------------------------
    | Cache Duration
    |--------------------------------------------------------------------------
    |
    | how long to keep items in cache
    | use 0 for keeping items forever in cache
    |
    */

    'cache_duration' => env('CG_CACHE_DURATION', 5),

];
