<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

/**
 * Class CreateModule
 * Creates new module in e-commerce style
 *
 * @package App\Console\Commands
 */
class CreateModule extends Command
{
    protected $modulesPath = 'app/Modules';
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:create {name : Module name}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new module with minimal structure';
    
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
        $name = $this->argument('name');
        if (preg_match('/\ /', $name)) {
            $this->error('Module name can not have spaces!');
            return;
        }
        if (File::isDirectory(base_path("{$this->modulesPath}/$name"))) {
            $this->error("Module {$name} already exists!");
            return;
        }
        $i18n = [];
        $aliasProposition = snake_case($name);
        if ($this->confirm("Your module alias is `$aliasProposition`. Is it OK for you?", 'yes')) {
            $alias = $aliasProposition;
        } else {
            $alias = $this->ask('Okay. Then type your alias');
        }
        $this->info("Your module alias is `$alias`");
        // Folders we always need
        $this->makeDirectory($name);
        $this->makeDirectory("$name/Controllers/Admin");
        $this->makeDirectory("$name/Models");
        $this->makeDirectory("$name/Forms");
        $this->makeDirectory("$name/Requests");
        $this->makeDirectory("$name/Filters");
        $this->makeDirectory("$name/Routes");
        // Routing for admin panel
        $template = file_get_contents(base_path('app/Console/Templates/admin-route.php'));
        $template = str_replace('{ModuleAlias}', $alias, $template);
        $this->makeFile("$name/Routes/admin.php", "<?php\n\n{$template}\n\n");
        // I18n integrations
        foreach (config('langs.list-for-admin', []) as $slug => $data) {
            $this->makeDirectory("$name/I18n/{$slug}");
            $permissionName = $this->ask("Please choose the name for permissions page ({$data['name']})");
            $i18n[$slug]['permission-name'] = $permissionName;
        }
        // Site parts
        if ($this->confirm('Will module have Site parts?', 'yes')) {
            $this->makeDirectory("$name/Controllers/Site");
            $this->makeDirectory("$name/Views/admin");
            $this->makeDirectory("$name/Views/site");
            $this->makeFile("$name/Routes/site.php", "<?php\n\nuse Illuminate\Support\Facades\Route;\n\n");
        } else {
            $this->makeDirectory("$name/Views");
        }
        // Migrations folder
        if ($this->confirm('Will module have migrations?', 'yes')) {
            $this->makeDirectory("$name/Database/Migrations");
        }
        // Seeders folder
        if ($this->confirm('Will module have seeders?')) {
            $this->makeDirectory("$name/Database/Seeds");
        }
        // Config file
        if ($this->confirm('Create configuration file for hidden settings?')) {
            $this->makeFile("$name/config.php", "<?php\n\nreturn [];");
        }
        $publicSettings = '';
        // Public settings
        if ($this->confirm('Will you need public settings for admin?', 'yes')) {
            $publicSettings = "\n        // Register module configurable settings\n" .
                "        \$settings = CustomSettings::createAndGet('{ModuleAlias}', '{ModuleAlias}::general.settings-name');";
            // I18n integrations
            foreach (config('langs.list-for-admin', []) as $slug => $data) {
                $settingsNameForLang = $this->ask("Please choose the name for settings ({$data['name']})");
                $i18n[$slug]['settings-name'] = $settingsNameForLang;
            }
        }
        foreach (config('langs.list-for-admin', []) as $slug => $data) {
            $settings = "<?php\n\nreturn [";
            foreach (array_get($i18n, $slug) as $key => $value) {
                $settings .= "\n    '{$key}' => '{$value}',";
            }
            $settings .= "\n];";
            $this->makeFile("$name/I18n/{$slug}/general.php", $settings);
        }
        // Make provider
        $template = file_get_contents(base_path('app/Console/Templates/provider-layout.php'));
        $afterBootTemplate = file_get_contents(base_path('app/Console/Templates/after-boot.php'));
        $afterBootForAdminTemplate = file_get_contents(base_path('app/Console/Templates/after-boot-admin.php'));
        $moduleNameSettings = '';
        if ($alias !== $aliasProposition) {
            $moduleNameSettings = "\n        \$this->setModuleName('$alias');" .
                                  "\n        \$this->setTranslationsNamespace('$alias');" .
                                  "\n        \$this->setViewNamespace('$alias');" .
                                  "\n        \$this->setConfigNamespace('$alias');";
        }
        // Form template
        $template = str_replace(
            ['{AfterBootForAdminPanel}', '{AfterBoot}', '{PublicSettings}', '{OwnModuleNameSettings}'],
            [$afterBootForAdminTemplate, $afterBootTemplate, $publicSettings, $moduleNameSettings],
            $template
        );
        $template = str_replace(
            ['{ModuleName}', '{ModuleAlias}'],
            [$name, $alias],
            $template
        );
        $this->makeFile("$name/Provider.php", "<?php\n\n$template");
        // Message to user
        $this->info("Please find config/app.php and put a row `App\Modules\\$name\Provider::class,` in the providers section");
    }
    
    /**
     * Make directory in one style
     *
     * @param $path
     */
    protected function makeDirectory($path)
    {
        File::makeDirectory(base_path("{$this->modulesPath}/$path"), $mode = 0777, true, true);
    }
    
    /**
     * Make file
     *
     * @param $path
     * @param string $content
     */
    protected function makeFile($path, $content = '')
    {
        File::put(base_path("{$this->modulesPath}/$path"), $content);
    }
}
