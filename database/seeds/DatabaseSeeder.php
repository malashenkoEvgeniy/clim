<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach (app()->getLoadedProviders() as $providerNamespace => $isLoaded) {
            if (
                strpos($providerNamespace, 'App\Modules') === 0 ||
                strpos($providerNamespace, 'App\Core\Modules') === 0
            ) {
                $provider = app()->getProvider($providerNamespace);
                if (
                    method_exists($provider, 'getDatabaseFolder') &&
                    method_exists($provider, 'getSeedersNamespace') &&
                    is_dir($provider->getDatabaseFolder() . '/Seeds')
                ) {
                    $files = scandir($provider->getDatabaseFolder() . '/Seeds');
                    foreach ($files as $file) {
                        if ($file === '.' || $file === '..' || $file === 'TranslatesSeeder.php') {
                            continue;
                        }
                        $file = Str::substr($file, 0, Str::length($file) - 4);
                        $this->call($provider->getSeedersNamespace() . '\\' . $file);
                    }
                }
            }
        }
    }
}
