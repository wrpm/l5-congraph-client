<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | Set default locale for urls
    |
    */

    'default_locale' => env('CG_DEFAULT_LOCALE', 'en_US'),


    /*
    |--------------------------------------------------------------------------
    | Use Localized Domains
    |--------------------------------------------------------------------------
    |
    | whether there are different domains for different locales
    |
    */

    'use_localized_domains' => env('CG_USE_LOCALIZED_DOMAINS', false),

    /*
    |--------------------------------------------------------------------------
    | Localized Domains
    |--------------------------------------------------------------------------
    |
    | a key => value list of domains with their respective home urls and locales
    |
    */

    'localized_domains' => [],
    /*
    | [ 'domain.com' => [
    |   'home_url' => 'home',
    |   'locale' => 'en_US',
    |   ],
    |   'domain.es' => [
    |   'home_url' => 'homa',
    |   'locale' => 'es_ES'
    |   ],
    | ]



    /*
    |--------------------------------------------------------------------------
    | Parent Keys
    |--------------------------------------------------------------------------
    |
    | field codes for parent relations
    |
    */

    'parent_keys' => [
        'parent_page',
        'property_type'
    ],



    /*
    |--------------------------------------------------------------------------
    | Use Meta Title Prefix
    |--------------------------------------------------------------------------
    |
    | whether to use prefix for meta title like Site name or similar
    | meta title will be appended to prefix with dash (-) as delimiter
    | example: Site Name - About Us
    |
    */

    'use_meta_title_prefix' => env('CG_USE_META_TITLE_PREFIX', false),

    /*
    |--------------------------------------------------------------------------
    | Meta Title Key
    |--------------------------------------------------------------------------
    |
    | field code for meta title value
    |
    */

    'meta_title_key' => env('CG_META_TITLE_KEY', 'meta_title'),

    /*
    |--------------------------------------------------------------------------
    | Meta Title Localized
    |--------------------------------------------------------------------------
    |
    | Flag for localized meta title attribute
    |
    */

    'meta_title_localized' => env('CG_META_TITLE_LOCALIZED', true),


    /*
    |--------------------------------------------------------------------------
    | Meta Description Key
    |--------------------------------------------------------------------------
    |
    | field code for meta description value
    |
    */

    'meta_description_key' => env('CG_META_DESCRIPTION_KEY', 'meta_description'),

    /*
    |--------------------------------------------------------------------------
    | Meta Description Localized
    |--------------------------------------------------------------------------
    |
    | Flag for localized meta Description attribute
    |
    */

    'meta_description_localized' => env('CG_META_DESCRIPTION_LOCALIZED', true),


    /*
    |--------------------------------------------------------------------------
    | Meta Keywords Key
    |--------------------------------------------------------------------------
    |
    | field code for meta keywords value
    |
    */

    'meta_keywords_key' => env('CG_META_KEYWORDS_KEY', 'meta_keywords'),

    /*
    |--------------------------------------------------------------------------
    | Meta Keywords Localized
    |--------------------------------------------------------------------------
    |
    | Flag for localized meta Keywords attribute
    |
    */

    'meta_keywords_localized' => env('CG_META_KEYWORDS_LOCALIZED', true),


    /*
    |--------------------------------------------------------------------------
    | OG Image Key
    |--------------------------------------------------------------------------
    |
    | field code for og image object value
    |
    */

    'og_image_key' => env('CG_OG_IMAGE_KEY', 'og_image'),

    /*
    |--------------------------------------------------------------------------
    | OG Image Localized
    |--------------------------------------------------------------------------
    |
    | Flag for localized og image attribute
    |
    */

    'og_image_localized' => env('CG_OG_IMAGE_LOCALIZED', false),


    /*
    |--------------------------------------------------------------------------
    | OG Image Version
    |--------------------------------------------------------------------------
    |
    | field code for og image version
    |
    */

    'og_image_version' => env('CG_OG_IMAGE_VERSION', ''),


    /*
    |--------------------------------------------------------------------------
    | Default OG Image
    |--------------------------------------------------------------------------
    |
    | URL for default OG Image (whole url: http://www.example.com/my_og_image.jpg)
    |
    */

    'default_og_image' => env('CG_OG_IMAGE', ''),

    
    /*
    |--------------------------------------------------------------------------
    | Localized Config
    |--------------------------------------------------------------------------
    |
    | You should define this set of values for each locale that you
    |
    */

    'en_US' => [

        /*
        |--------------------------------------------------------------------------
        | Home URL
        |--------------------------------------------------------------------------
        |
        | url for the home page, empty url will default to this page
        |
        */

        'home_url' => env('CG_EN_US_HOME_URL', 'home'),

        /*
        |--------------------------------------------------------------------------
        | Default Parents
        |--------------------------------------------------------------------------
        |
        | key => value list of default parent urls for attribute sets
        | example:
        | [ 'news' => ['blog_article', 'gallery_article', 'default_article'] ]
        |
        */

        'default_parents' => [
            'blog' => ['news_article']
        ],

        /*
        |--------------------------------------------------------------------------
        | Site Name
        |--------------------------------------------------------------------------
        |
        | Localized Site Name
        |
        */

        'site_name' => env('CG_EN_US_SITE_NAME', ''),


        /*
        |--------------------------------------------------------------------------
        | Meta Title Prefix
        |--------------------------------------------------------------------------
        |
        | When use_meta_title_prefix is set to TRUE, this value will be used as
        | prefix.
        |
        */

        'meta_title_prefix' => env('CG_EN_US_META_TITLE_PREFIX', ''),


        /*
        |--------------------------------------------------------------------------
        | Default Meta Title
        |--------------------------------------------------------------------------
        |
        | Default meta title value, for entities that don't have meta title defined
        |
        */

        'default_meta_title' => env('CG_EN_US_DEFAUTL_META_TITLE', ''),


        /*
        |--------------------------------------------------------------------------
        | Default Meta Description
        |--------------------------------------------------------------------------
        |
        | Default meta description value, for entities that don't have meta description defined
        |
        */

        'default_meta_description' => env('CG_EN_US_DEFAUTL_META_DESCRIPTION', ''),


        /*
        |--------------------------------------------------------------------------
        | Default Meta Keywords
        |--------------------------------------------------------------------------
        |
        | Default meta keywords value, for entities that don't have meta keywords defined
        |
        */

        'default_meta_keywords' => env('CG_EN_US_DEFAUTL_META_KEYWORDS', ''),
    ],

    'cs_CZ' => [

        /*
        |--------------------------------------------------------------------------
        | Home URL
        |--------------------------------------------------------------------------
        |
        | url for the home page, empty url will default to this page
        |
        */

        'home_url' => env('CG_CS_CZ_HOME_URL', 'domu'),

        /*
        |--------------------------------------------------------------------------
        | Default Parents
        |--------------------------------------------------------------------------
        |
        | key => value list of default parent urls for attribute sets
        | example:
        | [ 'news' => ['blog_article', 'gallery_article', 'default_article'] ]
        |
        */

        'default_parents' => [
            'novinky' => ['news_article']
        ],

        /*
        |--------------------------------------------------------------------------
        | Site Name
        |--------------------------------------------------------------------------
        |
        | Localized Site Name
        |
        */

        'site_name' => env('CG_CS_CZ_SITE_NAME', ''),


        /*
        |--------------------------------------------------------------------------
        | Meta Title Prefix
        |--------------------------------------------------------------------------
        |
        | When use_meta_title_prefix is set to TRUE, this value will be used as
        | prefix.
        |
        */

        'meta_title_prefix' => env('CG_CS_CZ_META_TITLE_PREFIX', ''),


        /*
        |--------------------------------------------------------------------------
        | Default Meta Title
        |--------------------------------------------------------------------------
        |
        | Default meta title value, for entities that don't have meta title defined
        |
        */

        'default_meta_title' => env('CG_CS_CZ_DEFAUTL_META_TITLE', ''),


        /*
        |--------------------------------------------------------------------------
        | Default Meta Description
        |--------------------------------------------------------------------------
        |
        | Default meta description value, for entities that don't have meta description defined
        |
        */

        'default_meta_description' => env('CG_CS_CZ_DEFAUTL_META_DESCRIPTION', ''),


        /*
        |--------------------------------------------------------------------------
        | Default Meta Keywords
        |--------------------------------------------------------------------------
        |
        | Default meta keywords value, for entities that don't have meta keywords defined
        |
        */

        'default_meta_keywords' => env('CG_CS_CZ_DEFAUTL_META_KEYWORDS', ''),
    ]
    

];
