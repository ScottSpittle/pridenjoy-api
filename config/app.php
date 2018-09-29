<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Info
    |--------------------------------------------------------------------------
    |
    | Here we define the application / api related information.
    |
    */

    'name' => env('APP_NAME', 'Lumen API Starter'),

    'old_secret' => env('APP_OLD_SECRET', false),

    'version' => env('APP_VERSION', 'unknown'),

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', 'SomeRandomString!!!'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */
    'locale' => env('APP_LOCALE', 'en'),
    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Register Service Providers
    |--------------------------------------------------------------------------
    |
    | Here we will register all of the application's service providers which
    | are used to bind services into the container. Service providers are
    | totally optional, so you are not required to uncomment this line.
    |
    */

    'providers' => [
        // App\Providers\AppServiceProvider::class => 'all',
        // App\Providers\AuthServiceProvider::class =>  'all',
        // App\Providers\EventServiceProvider::class => 'all',

        Barryvdh\Cors\ServiceProvider::class => 'all',
        Tymon\JWTAuth\Providers\LumenServiceProvider::class => 'all',
        Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class => ['development', 'local'],
        \App\Providers\MailServiceProvider::class => 'all'
    ],


    /*
    |--------------------------------------------------------------------------
    | Register Middleware
    |--------------------------------------------------------------------------
    |
    | Next, we will register the middleware with the application. These can
    | be global middleware that run before and after each request into a
    | route or middleware that'll be assigned to some specific routes.
    |
    */

    'middlewares' => [
        Barryvdh\Cors\HandleCors::class,
    ],

    'routeMiddlewares' => [
//        'auth' => App\Http\Middleware\Authenticate::class,
        'cors' => \Barryvdh\Cors\HandleCors::class,
    ],
];
