<?php

namespace App\Providers;


use App\Core\Modules\Languages\Models\Language;
use App\Core\Modules\Settings\Models\Setting;
use App\Widgets\Admin\Aside;
use App\Widgets\Admin\AsideElement;
use App\Widgets\Admin\Footer;
use App\Widgets\Admin\Active;
use App\Widgets\Admin\SystemMessage;
use Config, Widget, Schema, PaginateRoute, URL, App;
use Illuminate\Support\ServiceProvider;
use App\Widgets\Site\Breadcrumbs as SiteBreadcrumbs;
use App\Widgets\Site\H1 as SiteH1;
use App\Widgets\Site\SeoBlock as SiteSeoBlock;
use WezomAgency\Browserizr;
use App\Widgets\Site\Contacts as ContactsBlock;
use App\Widgets\Site\Logo;
use App\Widgets\Site\LogoMobile;
use App\Widgets\Site\ColorsPanel;
use App\Widgets\Site\ColorsSchema;
use App\Widgets\Site\DemoForm;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        PaginateRoute::registerMacros();
        // Register site languages to configurations
        if (Schema::hasTable('languages')) {
            Language::all()->sortByDesc('default')->each(
                function (Language $language) {
                    Config::set('languages.' . $language->slug, $language);
                }
            );
        }
        // Register widgets
        if (config('app.place') !== 'admin') {
            // For site
            $this->detectLanguageForSite();
            Config::set('jsvalidation.view', 'jsvalidation::site');
        } else {
            // For ORM in admin panel
            $this->detectOnlyDefaultSiteLanguage();
        }
        // Register configured settings from database
        if (Schema::hasTable('settings')) {
            Setting::all()->each(
                function (Setting $setting) {
                    Config::set("db.{$setting->group}.{$setting->alias}", $setting->value);
                }
            );
        }

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            Browserizr::detect();
        }
        Widget::register(App\Widgets\Image::class, 'image');

        // Registration of global widgets for admin panel
        if (config('app.place') === 'admin') {
            Widget::register(SystemMessage::class, 'system-message');
            Widget::register(Aside::class, 'aside');
            Widget::register(AsideElement::class, 'aside-element');
            Widget::register(Footer::class, 'footer');
            Widget::register(Active::class, 'active');
        }

        // Registration of global components for site panel
        if (config('app.place') === 'site') {
            // Blade::component('site._components.breadcrumbs.inline', 'breadcrumbs');
            Widget::register(SiteBreadcrumbs::class, 'breadcrumbs');
            Widget::register(SiteH1::class, 'h1');
            Widget::register(SiteSeoBlock::class, 'seo-block');
            Widget::register(ContactsBlock::class, 'contacts');
            Widget::register(Logo::class, 'logo');
            Widget::register(LogoMobile::class, 'logo-mobile');
            Widget::register(ColorsPanel::class, 'colors-panel');
            Widget::register(ColorsSchema::class, 'colors-schema');
            Widget::register(DemoForm::class, 'demo-form');
        }
    }

    /**
     * Detect language for site
     * Middleware is not a solution!
     */
    private function detectLanguageForSite()
    {
        // Detect default language
        $default = config('app.locale');
        foreach (config('languages', []) as $languageAlias => $language) {
            /**
             * @var \App\Core\Modules\Languages\Models\Language $language
             */
            if ($language->default) {
                $default = $language->slug;
                break;
            }
        }
        // Get language from URL
        $urlParts = explode('/', request()->path());
        $currentLanguage = array_shift($urlParts);
        $language = config('languages.' . $currentLanguage);
        // Set new locale for site
        App::setLocale($language ? $language->slug : $default);
        Config::set('app.locale', $language ? $language->slug : $default);
        Config::set('app.default-language', $default);
    }

    private function detectOnlyDefaultSiteLanguage()
    {
        // Detect default language
        $default = config('app.locale');
        foreach (config('languages', []) as $languageAlias => $language) {
            /**
             * @var \App\Core\Modules\Languages\Models\Language $language
             */
            if ($language->default) {
                $default = $language->slug;
                break;
            }
        }
        Config::set('app.default-language', $default);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Set application place type as admin panel
        if (preg_match('/\/' . config('app.admin_panel_prefix') . '\//', URL::current() . '/')) {
            // Set application type as admin panel
            Config::set('app.place', 'admin');
        }
        // Enable foreign keys
        Schema::enableForeignKeyConstraints();
        // Set max varchar field length
        Schema::defaultStringLength(191);
        // Debugger for dev purposes
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

}
