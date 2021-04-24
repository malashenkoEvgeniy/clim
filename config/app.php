<?php

use App\Modules\Pages\Provider;

return [

    /**
     * Admin panel namespace in URL
     * If this parameter changes then root .htaccess also needs to be changed
     */
    'admin_panel_prefix' => 'admin',

    /**
     * Set type of the place
     * In general parameter could be equal to 'admin' or 'site'
     */
    'place' => 'site',

    /**
     * Logo system settings
     */
    'logo' => [
        'path' => '',
        'filename' => 'logo.png',
        'urlPath' => 'storage',
    ],

    /**
     * Logo for mobile view system settings
     */
    'logo-mobile' => [
        'path' => '',
        'filename' => 'logo--mobile.png',
        'urlPath' => 'storage',
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'LocoTrade'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your "..env" file.
    |
    */

    '.env' => env('APP_ENV', 'development'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', true),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Europe/Kiev',

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

    'locale' => 'en',

    'default-language' => 'ru',

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

    'fallback_locale' => 'en',

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

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\MailServiceProvider::class,

        Collective\Html\HtmlServiceProvider::class,
        Proengsoft\JsValidation\JsValidationServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Spatie\PaginateRoute\PaginateRouteServiceProvider::class,

        EloquentFilter\ServiceProvider::class,

        Barryvdh\Debugbar\ServiceProvider::class,
        Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,


        /**
         * Core modules
         */
        App\Core\Modules\Translates\Provider::class,
        App\Core\Modules\Languages\Provider::class,
        App\Core\Modules\Mail\Provider::class,
        App\Core\Modules\Settings\Provider::class,
        App\Core\Modules\Administrators\Provider::class,
        App\Core\Modules\Images\Provider::class,
        App\Core\Modules\Dashboard\Provider::class,
        App\Core\Modules\SystemPages\Provider::class,
        App\Core\Modules\Security\Provider::class,
        App\Core\Modules\Notifications\Provider::class,

        /**
         * Custom modules
         */
        App\Modules\Sitemap\Provider::class,
        App\Modules\YandexMarket\Provider::class,
        App\Modules\Home\Provider::class,
        App\Modules\Users\Provider::class,
        App\Modules\Export\Provider::class,
        App\Modules\Reviews\Provider::class,
        App\Modules\News\Provider::class,
        App\Modules\Callback\Provider::class,
        App\Modules\Subscribe\Provider::class,
        App\Modules\SiteMenu\Provider::class,
        App\Modules\SlideshowSimple\Provider::class,
        App\Modules\SeoTemplates\Provider::class,
        App\Modules\SeoLinks\Provider::class,
        App\Modules\SeoScripts\Provider::class,
        App\Modules\SeoRedirects\Provider::class,
        App\Modules\SeoFiles\Provider::class,
        App\Modules\Products\Provider::class,
        App\Modules\Categories\Provider::class,
        App\Modules\Currencies\Provider::class,
        App\Modules\Brands\Provider::class,
        App\Modules\Features\Provider::class,
        App\Modules\LabelsForProducts\Provider::class,
        App\Modules\FastOrders\Provider::class,
        App\Modules\ProductsViewed\Provider::class,
        App\Modules\Wishlist\Provider::class,
        App\Modules\CompareProducts\Provider::class,
        App\Modules\Orders\Provider::class,
        App\Modules\Consultations\Provider::class,
        App\Modules\Articles\Provider::class,
        App\Modules\SocialButtons\Provider::class,
        App\Modules\Comments\Provider::class,
        App\Modules\Import\Provider::class,
        SocialiteProviders\Manager\ServiceProvider::class,
        App\Modules\ProductsAvailability\Provider::class,
        App\Modules\ProductsDictionary\Provider::class,
        App\Modules\ProductsServices\Provider::class,
        App\Modules\Services\Provider::class,
        App\Modules\Pages\Provider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [
        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,

        'Input' => Illuminate\Support\Facades\Input::class,
        'PaginateRoute' => Spatie\PaginateRoute\PaginateRouteFacade::class,

        'Debugbar' => Barryvdh\Debugbar\Facade::class,
        'Widget' => App\Components\Widget\Facade::class,
        'JsValidator' => Proengsoft\JsValidation\Facades\JsValidatorFacade::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'Seo' => App\Components\Seo\Facade::class,
        'CustomMenu' => App\Components\Menu\Facade::class,
        'CustomSiteMenu' => App\Components\SiteMenu\Facade::class,
        'CustomSettings' => App\Components\Settings\Facade::class,
        'CustomRoles' => App\Components\AdminRoleScopes\Facade::class,

        'Catalog' => App\Components\Catalog\Facade::class,
        'ProductsFilter' => App\Components\Filter\Facade::class,
    ],

];
