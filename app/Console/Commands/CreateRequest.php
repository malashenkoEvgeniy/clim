<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

/**
 * Class CreateForm
 *
 * @package App\Console\Commands
 */
class CreateRequest extends Command
{
    protected $modulesPath = 'app/Modules';
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:request {moduleName : Module name} {name : Request name}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates template file for request';
    
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
        $requestName = $this->argument('name');
        // Check module for existence
        if (!File::isDirectory(base_path("{$this->modulesPath}/$moduleName"))) {
            $this->error("Module {$moduleName} does not exist!");
            return;
        }
        // Check module for existence
        if (File::isFile(base_path("{$this->modulesPath}/$moduleName/Requests/$requestName.php"))) {
            $this->error("Request {$requestName} in module {$moduleName} already exists!");
            return;
        }
        // Make forms directory
        File::makeDirectory(base_path("{$this->modulesPath}/$moduleName/Requests"), $mode = 0777, true, true);
        // Generate template
        $view = "<?php\n\n" . file_get_contents(base_path("app/Console/Templates/request.php"));
        $view = str_replace(['{ModuleName}', '{RequestName}'], [$moduleName, $requestName], $view);
        // Create form file
        File::put(base_path("{$this->modulesPath}/$moduleName/Requests/$requestName.php"), $view);
        // Message to user
        $this->info("Request was created: {$this->modulesPath}/$moduleName/Requests/$requestName.php");
    }
}
