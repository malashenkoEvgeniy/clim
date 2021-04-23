<?php

namespace App\Core;

use App\Core\Modules\Languages\Models\Language;
use App\Core\Modules\Notifications\Types\NotificationType;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Config, Event;
use Illuminate\Support\Str;

/**
 * This a base provider class
 * Extend it by Provider class when you will create new module
 *
 * @package App\Core
 */
abstract class BaseProvider extends ServiceProvider
{
    
    /**
     * Module name
     *
     * @var string
     */
    protected $module;
    
    /**
     * Check if module could be registered or not
     *
     * @var bool
     */
    protected $canBeRegistered = true;
    
    /**
     * Global middleware list for all routes in module
     *
     * @var array
     */
    private $middleware = [];
    
    /**
     * Namespace for current Module
     * Watches in the root module folder
     *
     * @var string
     */
    private $moduleNamespace;
    
    /**
     * Controllers namespace
     * This is a part of controllers namespaces in the head of the php file
     *
     * @var string
     */
    private $routeNamespace;
    
    /**
     * Views namespace for use
     *
     * Usage: view('namespace::path.to.view');
     *
     * @var string
     */
    private $viewNamespace;
    
    /**
     * Config name to use
     *
     * Usage:
     * - config('namespace.attribute');
     * - \Config::get('namespace.attribute');
     *
     * @var string
     */
    private $configNamespace;
    
    /**
     * Translates namespace
     *
     * Usage:
     * - __('namespace::file.attributes');
     * - trans('namespace::file.attributes');
     * - Lang::get('namespace::file.attributes');
     *
     * Additional usage in blade templates: @lang('namespace::file.attributes')
     *
     * @var string
     */
    private $translatesNamespace;
    
    /**
     * Namespace for seeders
     *
     * @var string
     */
    private $seedersNamespace;
    
    /**
     * Namespace for listeners
     *
     * @var string
     */
    private $listenersNamespace;
    
    /**
     * Path to the routing folder
     *
     * @var string
     */
    private $routePath;
    
    /**
     * Path to the folder where you will create your views
     *
     * @var string
     */
    private $viewPath;
    
    /**
     * Path to the folder where you will create your migrations and seeders
     *
     * @var string
     */
    private $databasePath;
    
    /**
     * Path to the configuration file
     *
     * @var string
     */
    private $configPath;
    
    /**
     * Path to languages folder
     *
     * @var string
     */
    private $translatesPath;
    
    /**
     * Path to listeners folder
     *
     * @var string
     */
    private $listenersPath;
    
    /**
     * This is the first that laravel will execute
     */
    final public function register(): void
    {
        // Set default configuration
        $this->defaults();
        // Set custom configuration
        $this->presets();
        if ($this->canBeRegistered) {
            // Add config to global storage if exists
            if (file_exists($this->configPath)) {
                $this->mergeConfigFrom($this->configPath, $this->configNamespace);
            }
        }
    }
    
    /**
     * This method will be executed after all providers execute register() method
     * Here we can use all providers
     */
    final public function boot(): void
    {
        // Register migrations folder for current module
        $this->loadMigrationsFrom(rtrim($this->databasePath, '/') . '/Migrations');
        if ($this->canBeRegistered === false) {
            return;
        }
        // Register views folder with namespace
        $this->loadViewsFrom($this->viewPath, $this->viewNamespace);
        // Register translations folder path and alias
        $this->loadTranslations();
        // Add routes to global storage if file exists
        if (is_dir($this->routePath)) {
            // Include site routes
            $siteRoutesPath = $this->routePath . '/site.php';
            if (file_exists($siteRoutesPath)) {
                // Add default middleware
                $middleware = $this->middleware;
                if (in_array('web', $middleware) === false) {
                    array_unshift($middleware, 'web');
                }
                if (in_array('basicAuth', $middleware) === false) {
                    array_push($middleware, 'basicAuth');
                }
                // Include routes
                Route::prefix($this->getSitePrefix())
                    ->middleware(...$middleware)
                    ->namespace($this->routeNamespace . '\\Site')
                    ->group($siteRoutesPath);
            }
            
            // Include admin routes
            $adminRoutesPath = $this->routePath . '/admin.php';
            if (file_exists($adminRoutesPath)) {
                // Add default middleware
                $middleware = $this->middleware;
                if (in_array('web', $middleware) === false) {
                    array_unshift($middleware, 'web');
                }
                if (in_array('language', $middleware) === false) {
                    array_push($middleware, 'language');
                }
                // Include routes
                Route::prefix(config('app.admin_panel_prefix'))
                    ->middleware($middleware)
                    ->namespace($this->routeNamespace . '\\Admin')
                    ->group($adminRoutesPath);
            }
        }
        // Register widgets
        if (config('app.place') === 'admin') {
            // For admin panel
            $this->afterBootForAdminPanel();
        } else {
            // For site
            $this->afterBoot();
        }
        $this->registerListeners();
    }
    
    private function loadTranslations()
    {
        if (!is_dir($this->translatesPath)) {
            return;
        }
        foreach (scandir($this->translatesPath) as $lang) {
            if ($lang === '..' || $lang === '.') {
                continue;
            }
            if (is_dir($this->translatesPath . '/' . $lang) === false) {
                continue;
            }
            foreach (scandir($this->translatesPath . '/' . $lang) as $file) {
                if ($file === '..' || $file === '.') {
                    continue;
                }
                $path = $this->translatesPath . '/' . $lang . '/' . $file;
                if (is_dir($path)) {
                    continue;
                }
                $translates = require $path;
                if (!is_array($translates)) {
                    continue;
                }
                $translates = array_dot($translates, Str::replaceLast('.php', '', $file) . '.');
                \Lang::addLines($translates, $lang, $this->translatesNamespace);
            }
        }
    }
    
    /**
     * Get site prefix
     *
     * @return \Illuminate\Config\Repository|mixed|string
     */
    private function getSitePrefix()
    {
        foreach (config('languages', []) as $languageAlias => $language) {
            if (
                $language instanceof Language &&
                $language->slug === config('app.locale') &&
                !$language->default
            ) {
                return $language->slug;
            }
        }
        return '';
    }
    
    /**
     * Just presets. You can extend this method and set your own settings for current module
     */
    abstract protected function presets();
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
    }
    
    /**
     * Register module widgets and menu elements here for admin side of the site
     */
    protected function afterBootForAdminPanel()
    {
    }
    
    /**
     * Default presets
     * This presets will be used by default
     */
    private function defaults(): void
    {
        // Parse some data we need from provider namespace
        $providerClassParts = explode('\\', static::class);
        // Remove last element with class name
        array_pop($providerClassParts);
        // Get namespace from ::class
        $this->moduleNamespace = implode('\\', $providerClassParts);
        // Snake case from module name
        $alias = snake_case(array_pop($providerClassParts));
        // Path to current module
        $pathToModule = str_replace(['\\', 'App'], ['/', 'app'], $this->moduleNamespace);
        // Set data we need
        $this->setModuleName($alias);
        $this->setViewNamespace($alias);
        $this->setRouteNamespace($this->moduleNamespace . '\\Controllers');
        $this->setSeedersNamespace($this->moduleNamespace . '\\Database\\Seeds');
        $this->setConfigNamespace($alias);
        $this->setTranslationsNamespace($alias);
        $this->setDatabaseFolder(base_path($pathToModule . '/Database'));
        $this->setViewPath(base_path($pathToModule . '/Views'));
        $this->setRoutePath(base_path($pathToModule . '/Routes'));
        $this->setConfigPath(base_path($pathToModule . '/config.php'));
        $this->setTranslationsPath(base_path($pathToModule . '/I18n'));
        $this->setListenersPath(base_path($pathToModule . '/Listeners'));
        $this->setListenersNamespace($this->moduleNamespace . '\\Listeners');
    }
    
    /**
     * Add middleware to the list
     *
     * @param string[] $middleware
     */
    final protected function registerMiddleware(...$middleware): void
    {
        $this->middleware = array_merge($this->middleware, $middleware);
    }
    
    /**
     * Set custom database folder
     * This is path to migrations and seeders for current module
     *
     * @param string $path
     */
    final protected function setDatabaseFolder(string $path): void
    {
        $this->databasePath = $path;
    }
    
    /**
     * Set route namespace
     * This is the base path to controllers for current module
     *
     * @param string $namespace
     */
    final protected function setRouteNamespace(string $namespace): void
    {
        $this->routeNamespace = $namespace;
    }
    
    /**
     * Set path to file with routes
     *
     * @param string $path
     */
    final protected function setRoutePath(string $path): void
    {
        $this->routePath = $path;
    }
    
    /**
     * Set namespace for views
     *
     * @param string $namespace
     */
    final protected function setViewNamespace(string $namespace): void
    {
        $this->viewNamespace = $namespace;
    }
    
    /**
     * Set path to the folder with views for current module
     *
     * @param string $path
     */
    final protected function setViewPath(string $path): void
    {
        $this->viewPath = $path;
    }
    
    /**
     * Set config name
     * We will use it to get some module configurations
     *
     * @param string $namespace
     */
    final protected function setConfigNamespace(string $namespace): void
    {
        $this->configNamespace = $namespace;
    }
    
    /**
     * Set translations namespace
     *
     * @param string $namespace
     */
    final protected function setTranslationsNamespace(string $namespace): void
    {
        $this->translatesNamespace = $namespace;
    }
    
    /**
     * Set path to the file with module configurations
     *
     * @param string $path
     */
    final protected function setConfigPath(string $path): void
    {
        $this->configPath = $path;
    }
    
    /**
     * Set path to the folder with translates for module
     *
     * @param string $path
     */
    final protected function setTranslationsPath(string $path): void
    {
        $this->translatesPath = $path;
    }
    
    /**
     * Set path to the folder with listeners for module
     *
     * @param string $path
     */
    final protected function setListenersPath(string $path): void
    {
        $this->listenersPath = $path;
    }
    
    /**
     * Set namespace for Seeders
     *
     * @param string $namespace
     */
    final protected function setSeedersNamespace(string $namespace): void
    {
        $this->seedersNamespace = $namespace;
    }
    
    /**
     * Set namespace for LListeners
     *
     * @param string $namespace
     */
    final protected function setListenersNamespace(string $namespace): void
    {
        $this->listenersNamespace = $namespace;
    }
    
    /**
     * Set module name
     *
     * @param string $namespace
     */
    final protected function setModuleName(string $namespace): void
    {
        $this->module = $namespace;
    }
    
    /**
     * Get namespace for Seeders
     *
     * @return string
     */
    final public function getSeedersNamespace(): string
    {
        return $this->seedersNamespace;
    }
    
    /**
     * Get path to the file with module configurations
     *
     * @return string
     */
    final public function getConfigPath(): string
    {
        return $this->configPath;
    }
    
    /**
     * Get custom database folder
     * This is path to migrations and seeders for current module
     *
     * @return string
     */
    final public function getDatabaseFolder(): string
    {
        return $this->databasePath;
    }
    
    /**
     * Get module name
     *
     * @return string
     */
    final public function getModule(): string
    {
        return $this->module;
    }
    
    /**
     * Get translations namespace
     *
     * @return string
     */
    final public function getTranslationsNamespace(): string
    {
        return $this->translatesNamespace;
    }
    
    /**
     * Get listeners namespace
     *
     * @return string
     */
    final public function getListenersNamespace(): string
    {
        return $this->listenersNamespace;
    }
    
    /**
     * Register notification type in the system to use
     *
     * @param string $type
     * @param null|string $icon
     * @param null|string $color
     */
    final public function registerNotificationType(string $type, ?string $icon = null, ?string $color = null): void
    {
        $this->app->booted(function () use ($type, $icon, $color) {
            $notificationType = new NotificationType();
            $notificationType->setType($type);
            $notificationType->setColor($color);
            $notificationType->setIcon($icon);
            Config::set('notifications.' . $type, $notificationType);
        });
    }
    
    /**
     * Register listeners
     */
    final protected function registerListeners(): void
    {
        if (is_dir($this->listenersPath) === false) {
            return;
        }
        foreach (scandir($this->listenersPath) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $className = str_replace('.php', '', $file);
            $listenerNamespace = $this->listenersNamespace . "\\" . $className;
            if (method_exists($listenerNamespace, 'listens')) {
                foreach ((array)$listenerNamespace::listens() as $listen) {
                    Event::listen($listen, $listenerNamespace);
                }
            }
        }
    }

    final public function getTranslationFolder()
    {


       return  $this->translatesPath;
    }

    final public function getModuleName()
    {
        return $this->module;
    }
    
}
