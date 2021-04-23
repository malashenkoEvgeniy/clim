<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

/**
 * Class Clear
 *
 * @package App\Console\Commands
 */
class Clear extends Command
{
    use ConfirmableTrait;
    
    protected $modulesPath = 'app/Modules';
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locotrade:clear';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cache and other no needed information';
    
    /**
     * @throws \Exception
     */
    public function handle()
    {
        $this->call('clear');
        $this->call('cache:clear');
        $this->call('view:clear');
        $this->call('optimize:clear');
        $this->call('config:clear');
    }
    
}
