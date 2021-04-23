<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan, File;

/**
 * Class CreateForm
 *
 * @package App\Console\Commands
 */
class RunSeed extends Command
{
    protected $modulesPath = 'app/Modules';
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:run-seed {moduleName : Module name} {name : Seeder name}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs seeder inside module';
    
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
        $moduleName = $this->argument('moduleName');
        $seederName = $this->argument('name');
    
        if (!File::isDirectory(base_path("{$this->modulesPath}/$moduleName"))) {
            $this->error("Module {$moduleName} does not exist!");
            return;
        }
    
        $seederClassName = "\\App\\Modules\\$moduleName\\Database\\Seeds\\$seederName";
        if (class_exists($seederClassName) === false) {
            $this->error("Seeder $seederName doesn't exist!");
            return;
        }
        
        Artisan::call('db:seed', [
            '--class' => $seederClassName,
        ]);
        
        $this->info('Seeder executed!');
    }
}
