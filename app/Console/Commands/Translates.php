<?php

namespace App\Console\Commands;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Str;
use Schema;

/**
 * Class Translates
 *
 * @package App\Console\Commands
 */
class Translates extends Command
{
    use ConfirmableTrait;
    
    protected $modulesPath = 'app/Modules';
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locotrade:translates {--force}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds static translates';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * @throws \Exception
     */
    public function handle()
    {
        $force = $this->option('force');
        if (!$force) {
            if (isProd()) {
                $confirmed = $this->confirm('Do you really wish to run this command?');
                if (!$confirmed) {
                    $this->comment('Command Cancelled!');
                    return false;
                }
            }
        }
        
        if (Schema::hasTable((new Translate)->getTable()) === false) {
            $this->warn('Can not save translates! Table ' . (new Translate)->getTable() . ' does not exist');
            return true;
        }
        if (!$force) {
            if (isLocal() && ($this->confirm('Do you need to remove old translates?'))) {
                Translate::query()->delete();
            }
        }
        
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
                        if ($file === '.' || $file === '..' || $file !== 'TranslatesSeeder.php') {
                            continue;
                        }
                        $file = Str::substr($file, 0, Str::length($file) - 4);
                        $this->call('db:seed', [
                            '--class' => $provider->getSeedersNamespace() . '\\' . $file,
                            '--force' => true,
                        ]);
                    }
                }
            }
        }
        $this->info('Translates seeded!');
    }
    
}
