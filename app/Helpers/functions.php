<?php

if (!function_exists('admin_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string $path
     * @param  bool $secure
     * @return string
     */
    function admin_asset($path, $secure = null)
    {
        return asset(config('app.admin_panel_prefix') . '/' . ltrim($path, '/'), $secure);
    }
}

if (!function_exists('admin_url')) {
    /**
     * Generate a url for the application.
     *
     * @param  string $path
     * @param  mixed $parameters
     * @param  bool $secure
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function admin_url($path = null, $parameters = [], $secure = null)
    {
        return url(config('app.admin_panel_prefix') . '/' . ltrim($path, '/'), $parameters, $secure);
    }
}

if (!function_exists('site_media')) {
    /**
     * @param  string $path
     * @param  bool $version
     * @param  bool $secure
     * @param  bool $absolute
     * @return string
     */
    function site_media(string $path, bool $version = false, bool $secure = false, bool $absolute = false)
    {
        $browserPath = '/' . trim($path, '/');
        if ($version) {
            $fsPath = site_fs_path($path);
            if (is_file($fsPath)) {
                $browserPath = $browserPath . '?v=' . filemtime($fsPath);
            }
        }
        if ($secure || $absolute) {
            $browserPath = asset($browserPath, $secure);
        }
        return $browserPath;
    }
}

if (!function_exists('site_fs_path')) {
    /**
     * @param  string $path
     * @return string
     */
    function site_fs_path(string $path)
    {
        $clean_path = explode('?', $path)[0];
        $clean_path = explode('#', $clean_path)[0];
        $clean_path = 'site/' . trim($clean_path, '/');
        return (public_path($clean_path));
    }
}

if (!function_exists('site_get_contents')) {
    /**
     * @param  string $path
     * @return string
     */
    function site_get_contents(string $path)
    {
        $path = site_fs_path($path);
        if (is_file($path)) {
            return file_get_contents($path);
        }
        return '';
    }
}

if (!function_exists('site_plural')) {
    /**
     * @param  int $number
     * @param  array $words
     * @return string
     */
    function site_plural(int $number, array $words = ['товар', 'товара', 'товаров'])
    {
        $ar = [2, 0, 1, 1, 1, 2];
        return $words[ ($number%100 > 4 && $number%100 < 20) ? 2 : $ar[min($number%10, 5)] ];
    }
}

if (!function_exists('isEnv')) {
    /**
     * Checks application environment
     *
     * @param  string $environment
     * @return string
     */
    function isEnv(string $environment)
    {
        return env('APP_ENV') === $environment;
    }
}

if (!function_exists('isDemo')) {
    /**
     * Checks if application environment is `demo`
     *
     * @return string
     */
    function isDemo()
    {
        return isEnv('demo');
    }
}

if (!function_exists('isLocal')) {
    /**
     * Checks if application environment is `local`
     *
     * @return string
     */
    function isLocal()
    {
        return isEnv('local');
    }
}

if (!function_exists('isProd')) {
    /**
     * Checks if application environment is `production`
     *
     * @return string
     */
    function isProd()
    {
        return isEnv('production');
    }
}

if (!function_exists('browserizr')) {
    /**
     * Get Browserizr instance
     * @return \WezomAgency\Browserizr
     */
    function browserizr()
    {
        return \WezomAgency\Browserizr::detect();
    }
}

if (!function_exists('r2d2')) {
    /**
     * Get R2D2 instance
     * @return \WezomAgency\R2D2
     */
    function r2d2()
    {
        return \WezomAgency\R2D2::eject();
    }
}


if (!function_exists('isSecure')) {
    /**
     * Checks if application environment using https
     *
     * @return string
     */
    function isSecure()
    {
        return env('PROTOCOL') == 'https' ? true : false;
    }
}
