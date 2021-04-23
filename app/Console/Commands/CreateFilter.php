<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

/**
 * Class CreateForm
 *
 * @package App\Console\Commands
 */
class CreateFilter extends Command
{
    protected $modulesPath = 'app/Modules';
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:filter {moduleName : Module name} {name : Filter name}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates template file for filter';
    
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
        $filterName = $this->argument('name');
        // Check module for existence
        if (!File::isDirectory(base_path("{$this->modulesPath}/$moduleName"))) {
            $this->error("Module {$moduleName} does not exist!");
            return;
        }
        // Check module for existence
        if (File::isFile(base_path("{$this->modulesPath}/$moduleName/Filters/$filterName.php"))) {
            $this->error("Filter {$filterName} in module {$moduleName} already exists!");
            return;
        }
        // Make forms directory
        File::makeDirectory(base_path("{$this->modulesPath}/$moduleName/Filters"), $mode = 0777, true, true);
        // Generate template
        $view = "<?php\n\n" . file_get_contents(base_path("app/Console/Templates/filter.php"));
        $view = str_replace(['{ModuleName}', '{FilterName}'], [$moduleName, $filterName], $view);
        // Create form file
        File::put(base_path("{$this->modulesPath}/$moduleName/Filters/$filterName.php"), $view);
        // Message to user
        $this->info("Filter was created: {$this->modulesPath}/$moduleName/Filters/$filterName.php");
    }
}
