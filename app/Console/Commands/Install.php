<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan, File;

/**
 * Class CreateForm
 *
 * @package App\Console\Commands
 */
class Install extends Command
{
    protected $modulesPath = 'app/Modules';
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locotrade:install {--force}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simple form of Locotrade system installation';
    
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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $force = $this->option('force');
        if ($force || isDemo() || $this->confirm('Вы уверены? Это действие полностью почистит БД и наполнит ее тестовыми данными. Это необратимо!', false)) {
            $this->call('key:generate');
            $this->call('migrate:fresh', ['--force' => $force]);
            File::delete(public_path('storage'));
            $this->call('storage:link');
            File::makeDirectory(storage_path('app/public/files'), $mode = 0777, true, true);
            File::makeDirectory(storage_path('app/public/files/thumbs'), $mode = 0777, true, true);
            File::makeDirectory(storage_path('app/public/files/filemanager'), $mode = 0777, true, true);
            File::makeDirectory(storage_path(), $mode = 0777, true, true);
            File::makeDirectory(base_path('bootstrap'), $mode = 0777, true, true);
            $this->call('db:seed', ['--force' => $force]);
            $this->call('locotrade:translates', ['--force' => $force]);
            if ($force || isDemo() || $this->confirm('Наполнить сайт тестовыми данными? Команда отработает только при распакованном demo архиве в папку storage/app', false)) {
                $this->call('db:seed', ['--class' => 'RestoreDemoDataSeeder', '--force' => true]);
            }
            $this->info('Готово!');
        } else {
            $this->info('Отменено!');
        }
    }
}
