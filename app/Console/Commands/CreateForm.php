<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

/**
 * Class CreateForm
 *
 * @package App\Console\Commands
 */
class CreateForm extends Command
{
    protected $modulesPath = 'app/Modules';
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:form {moduleName : Module name} {name : Form file name}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates template file for form';
    
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
        $formName = $this->argument('name');
        // Check module for existence
        if (!File::isDirectory(base_path("{$this->modulesPath}/$moduleName"))) {
            $this->error("Module {$moduleName} does not exist!");
            return;
        }
        // Check module for existence
        if (File::isFile(base_path("{$this->modulesPath}/$moduleName/Forms/$formName.php"))) {
            $this->error("Form {$formName} in module {$moduleName} already exists!");
            return;
        }
        // Make forms directory
        File::makeDirectory(base_path("{$this->modulesPath}/$moduleName/Forms"), $mode = 0777, true, true);
        // Additional questions block
        $modelNamespace = $fullNamespace = $modelName = '';
        if ($this->confirm('Do you want to link model?', 'yes')) {
            $modelNamespace = $this->ask('Model namespace inside Models folder');
            // Check if class exists
            $path = base_path("{$this->modulesPath}/$moduleName/Models/$modelNamespace.php");
            if (!File::isFile($path)) {
                $this->error("Chosen model $path doesn't exist!");
                return;
            }
            $temp = explode('\\', $modelNamespace);
            $modelName = end($temp);
            $fullNamespace = ucfirst($this->modulesPath) . "\\$moduleName\\Models\\$modelNamespace";
            $fullNamespace = str_replace('/', '\\', $fullNamespace);
        }
        // Generate template
        $view = "<?php\n\n" . file_get_contents(base_path("app/Console/Templates/form.php"));
        $view = str_replace([
            '{ModuleName}', '{FormName}', '{ModelNamespace}', '{ModelName}', '{ModelNameWithStem}',
            '{ModelRegistration}', '{FullModelNamespace}',
        ], [
            $moduleName, $formName, $modelNamespace, $modelName, "|$modelName",
            $modelName ? "\n        " . '$model = $model ?? new ' . $modelName . ';' : '',
            $fullNamespace ? "\nuse $fullNamespace;" : '',
        ], $view);
        // Create form file
        File::put(base_path("{$this->modulesPath}/$moduleName/Forms/$formName.php"), $view);
        // Message to user
        $this->info("Form was created: {$this->modulesPath}/$moduleName/Forms/$formName.php");
    }
}
