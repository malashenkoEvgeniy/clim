<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File, Artisan;
use Illuminate\Support\Str;

/**
 * Class CreateForm
 *
 * @package App\Console\Commands
 */
class CreateMail extends Command
{
    protected $modulesPath = 'app/Modules';
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:mail {moduleName : Module name}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates files for mail template';
    
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
        // Check module for existence
        if (!File::isDirectory(base_path("{$this->modulesPath}/$moduleName"))) {
            $this->error("Module {$moduleName} does not exist!");
            return;
        }
        $provider = app()->getProvider("App\\Modules\\$moduleName\\Provider");
        if (!$provider) {
            $this->error("Module {$moduleName} does not exist!");
            return;
        }
        if (
            !method_exists($provider, 'getModule') ||
            !method_exists($provider, 'getTranslationsNamespace')
        ) {
            $this->error("Module {$moduleName} is system!");
            return;
        }
        $moduleAlias = $provider->getModule();
        $seederName = $this->ask('Your seeder name');
        if (!$seederName) {
            $this->error("Wrong input data!");
            return;
        }
        // Check module for existence
        if (File::isFile(base_path("{$this->modulesPath}/$moduleName/Database/Seeds/$seederName.php"))) {
            $this->error("Seeder {$seederName} in module {$moduleName} already exists!");
            return;
        }
        // Make forms directory
        $this->makeDirectory("$moduleName/Database/Seeds");
        $mailAlias = $this->ask('Choose alias for your mail');
        if (!$seederName) {
            $this->error("Wrong input data!");
            return;
        }
        $usersVariables = $this->ask('Add your variables. Use "," as separator');
        // Generate template
        $view = "<?php\n\n" . file_get_contents(base_path("app/Console/Templates/mail-seeder.php"));
        $view = str_replace([
            '{ModuleName}',
            '{ModuleAlias}',
            '{SeederName}',
            '{MailAlias}',
            '{SeederVariables}',
            '{TranslationsNamespace}',
        ], [
            $moduleName,
            $moduleAlias,
            $seederName,
            $mailAlias,
            $this->variables($usersVariables, $moduleAlias),
            $provider->getTranslationsNamespace(),
        ], $view);
        // Create form file
        $this->makeFile("$moduleName/Database/Seeds/$seederName.php", $view);
        // Create I18n files
        $this->i18n($moduleName, $mailAlias, $usersVariables);
        // Create Event
        $eventName = $this->event($moduleName, studly_case($mailAlias), $usersVariables);
        // Create event listener
        $listenerName = $this->listener($moduleName, $mailAlias, $usersVariables);
        // Message to user
        $modulesPath = str_replace('/', '\\', $this->modulesPath);
    
        Artisan::call('db:seed', [
            '--class' => ucfirst($modulesPath) . "\\$moduleName\\Database\\Seeds\\$seederName",
        ]);
        
        $this->info("All files were created.");
        $this->info("Add line Event::listen($eventName::class, $listenerName::class); to your $moduleName Provider.php");
        $this->info("You could type Event::fire(new $eventName('yourParameters')); to send the email");
    }
    
    /**
     * Create listener file
     *
     * @param string $moduleName
     * @param string $mailAlias
     * @param string $usersVariables
     * @return string
     */
    private function listener(string $moduleName, string $mailAlias, string $usersVariables)
    {
        $variables = explode(',', $usersVariables);
    
        $space = "    ";
    
        if (
            (
                count($variables) === 1 &&
                !in_array('email', $variables)
            ) ||
            count($variables) > 1
        ) {
            $variablesKeys = $variablesValues = "";
            foreach ($variables as $variable) {
                $variablesKeys .= "\n{$space}{$space}{$space}'$variable',";
                $variablesValues .= "\n{$space}{$space}{$space}\$event->$variable,";
            }
            $variablesKeys .= "\n{$space}{$space}";
            $variablesValues .= "\n{$space}{$space}";
        }
        
        $studlyMailAlias = studly_case($mailAlias);
        $listenerName = $studlyMailAlias . 'Listener';
        $eventName = $studlyMailAlias . 'Event';
        $this->makeDirectory("$moduleName/Listeners");
        
        $listener = "<?php\n\n" . file_get_contents(base_path("app/Console/Templates/mail-listener.php"));
        $listener = str_replace([
            '{ModuleName}',
            '{RelatedEventName}',
            '{ListenerName}',
            '{MailAlias}',
            '{ListenerVariablesKeys}',
            '{ListenerVariablesValues}',
        ], [
            $moduleName,
            $eventName,
            $listenerName,
            $mailAlias,
            $variablesKeys ?? '',
            $variablesValues ?? '',
        ], $listener);
        
        $this->makeFile("$moduleName/Listeners/$listenerName.php", $listener);
        
        return $listenerName;
    }
    
    /**
     * Create event file
     *
     * @param string $moduleName
     * @param string $eventName
     * @param string $usersVariables
     * @return string
     */
    private function event(string $moduleName, string $eventName, string $usersVariables)
    {
        $variables = explode(',', $usersVariables);
        $eventName = $eventName . 'Event';
        $this->makeDirectory("$moduleName/Events");
        
        $space = "    ";
        
        if (
            (
                count($variables) === 1 &&
                !in_array('email', $variables)
            ) ||
            count($variables) > 1
        ) {
            $properties = $phpDoc = $propertiesList = $setProperties = "";
            foreach ($variables as $variable) {
                if ($variable === 'email') {
                    continue;
                }
                $properties .= "\n\n{$space}/**\n{$space} * @var string\n{$space} */\n{$space}public \$$variable;";
                $phpDoc .= "\n{$space} * @param string \$$variable";
                $propertiesList .= ", string \$$variable";
                $setProperties .= "\n{$space}{$space}\$this->$variable = \$$variable;";
            }
        }
        
        $event = "<?php\n\n" . file_get_contents(base_path("app/Console/Templates/mail-event.php"));
        $event = str_replace([
            '{ModuleName}',
            '{EventName}',
            '{EventProperties}',
            '{EventPropertiesPhpDoc}',
            '{EventPropertiesList}',
            '{SetEventProperties}',
        ], [
            $moduleName,
            $eventName,
            $properties ?? "",
            $phpDoc ?? "",
            $propertiesList ?? "",
            $setProperties ?? "",
        ], $event);
        
        $this->makeFile("$moduleName/Events/$eventName.php", $event);
        
        return $eventName;
    }
    
    /**
     * I18n integrations
     *
     * @param string $moduleName
     * @param string $mailAlias
     * @param string $usersVariables
     */
    private function i18n(string $moduleName, string $mailAlias, string $usersVariables)
    {
        $space = '    ';
        $variables = explode(',', $usersVariables);
        foreach (config('langs.list-for-admin', []) as $slug => $data) {
            $this->makeDirectory("$moduleName/I18n/$slug");
            $value = Str::ucfirst(snake_case($mailAlias, ' '));
            $i18n = "<?php\n\nreturn [\n$space'names' => [\n$space$space'$mailAlias' => '$value',\n$space],\n" .
                "$space'attributes' => [\n";
            foreach ($variables as $variable) {
                $value = Str::ucfirst(snake_case($variable, ' '));
                $i18n .= "$space$space'$variable' => '$value',\n";
            }
            $i18n .= "$space],\n];";
            $this->makeFile("$moduleName/I18n/$slug/mail-templates.php", $i18n);
        }
    }
    
    /**
     * Ask for variables list
     *
     * @param string $usersVariables
     * @param string $moduleAlias
     * @return string
     */
    private function variables(string $usersVariables, string $moduleAlias)
    {
        $usersVariables = explode(',', $usersVariables);
        $variables = "[\n";
        foreach ($usersVariables as $variable) {
            $variable = str_slug($variable);
            $variables .= "            '$variable' => '$moduleAlias::mail-templates.attributes.$variable',\n";
        }
        $variables .= "        ]";
        return $variables;
    }
    
    /**
     * Make directory in one style
     *
     * @param $path
     */
    private function makeDirectory($path)
    {
        File::makeDirectory(base_path("{$this->modulesPath}/$path"), $mode = 0777, true, true);
    }
    
    /**
     * Make file
     *
     * @param $path
     * @param string $content
     */
    private function makeFile($path, $content = '')
    {
        File::put(base_path("{$this->modulesPath}/$path"), $content);
    }
}
