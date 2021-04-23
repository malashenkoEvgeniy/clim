<?php

namespace App\Modules\Import\Jobs;

use App\Modules\Import\Components\Import as ImportComponent;
use App\Modules\Import\Components\ImportSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Modules\Import\Models\Import as ImportModel;
use Illuminate\Support\Str;

/**
 * Class Import
 *
 * @package App\Jobs
 */
class Import implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
     * @var string
     */
    protected $url;
    
    /**
     * @var ImportModel
     */
    protected $import;
    
    /**
     * @var ImportSettings
     */
    protected $settings;
    
    /**
     * @var null|string
     */
    protected $type;
    
    /**
     * Create a new job instance.
     *
     * @param string $url
     * @param ImportModel $import
     * @param null|string $type
     * @return void
     */
    public function __construct(string $url, ImportModel $import, string $type = null)
    {
        $this->url = $url;
        $this->import = $import;
        $this->settings = new ImportSettings($import->data);
        $this->type = $type;
    }
    
    /**
     * @throws \Throwable
     */
    public function handle()
    {
        $this->import->update([
            'status' => ImportModel::STATUS_PROCESSING,
        ]);

        $import = new ImportComponent($this->url, $this->settings, $this->type);
        $import->start();

        $this->import->update([
            'status' => ImportModel::STATUS_DONE,
        ]);
    }
    
    /**
     * The job failed to process.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        $this->import->update([
            'status' => ImportModel::STATUS_FAILED,
            'message' => Str::substr($exception->getMessage(), 0, 180),
        ]);
    }
    
    /**
     * @return ImportSettings
     */
    public function getSettings(): ImportSettings
    {
        return $this->settings;
    }
    
}
