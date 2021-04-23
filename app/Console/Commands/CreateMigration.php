<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan, File;

/**
 * Class CreateForm
 *
 * @package App\Console\Commands
 */
class CreateMigration extends Command
{
    protected $modulesPath = 'app/Modules';
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:migration {moduleName : Module name} {name : Migration table name}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates migration inside module';
    
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
        $migrationName = $this->argument('name');
    
        if (!File::isDirectory(base_path("{$this->modulesPath}/$moduleName"))) {
            $this->error("Module {$moduleName} does not exist!");
            return;
        }
        
        $pathToTheMigrationsFolder = "/{$this->modulesPath}/$moduleName/Database/Migrations";
        if (!File::isDirectory(base_path($pathToTheMigrationsFolder))) {
            File::makeDirectory(base_path($pathToTheMigrationsFolder), $mode = 0777, true, true);
        }
    
        $tableName = $this->ask('Table name?');
        $tableName = snake_case($tableName) ?: snake_case($migrationName);
        
        Artisan::call('make:migration', [
            'name' => $migrationName,
            '--path' => $pathToTheMigrationsFolder,
            '--create' => $tableName,
        ]);
        
        $this->info('Migration created!');
    }
}
