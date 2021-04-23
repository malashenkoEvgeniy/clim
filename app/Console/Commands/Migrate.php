<?php

namespace App\Console\Commands;

use App\Components\Settings\Models\Setting;
use App\Core\Modules\Languages\Models\Language;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\Products\Models\ProductGroupFeatureValue;
use App\Modules\ProductsDictionary\Database\Seeds\ProductDictionarySeeder;
use App\Modules\ProductsServices\Models\ProductService;
use App\Modules\ProductsServices\Models\ProductServiceTranslates;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Str;

/**
 * Class Migrate
 *
 * @package App\Console\Commands
 */
class Migrate extends Command
{
    use ConfirmableTrait;

    protected $modulesPath = 'app/Modules';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locotrade:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate from simple catalog to catalog with modifications';

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
     * @throws \Exception
     */
    public function handle()
    {
        $this->call('migrate', [
            '--force' => true,
        ]);
        $this->call('locotrade:translates', [
            '--force' => true,
        ]);
        $this->updateImagesFolders();
        $this->call('locotrade:clear');
//        $this->updateMailTemplates();
//        $this->defaultMigration();
    }
    
    private function updateImagesFolders()
    {
        foreach (\File::directories(storage_path('app/public')) as $directory) {
            $folderName = explode('/', $directory);
            $folderName = end($folderName);
            if (in_array($folderName, ['files', 'temp'])) {
                continue;
            }
            foreach (scandir($directory) as $item) {
                if (in_array($item, ['.', '..']) || is_dir($directory . '/' . $item) === false) {
                    continue;
                }
                if ($item === 'original') {
                    foreach (scandir($directory . '/' . $item) as $file) {
                        if (in_array($file, ['.', '..'])) {
                            continue;
                        }
                        \File::move($directory . '/' . $item . '/' . $file, $directory . '/' . $file);
                    }
                }
                \File::deleteDirectory($directory . '/' . $item);
            }
        }
    }
    
    /**
     * @throws \Exception
     */
    private function updateProductServices()
    {
        if (ProductService::all()->isNotEmpty()) {
            return;
        }
        
        $services = [
            [
                'name' => config('db.basic.delivery_title'),
                'description' => config('db.basic.delivery_short_text'),
                'text' => config('db.basic.delivery_text'),
                'icon' => 'icon-delivery',
            ],
            [
                'name' => config('db.basic.payment_title'),
                'description' => config('db.basic.payment_short_text'),
                'text' => config('db.basic.payment_text'),
                'icon' => 'icon-payment',
            ],
            [
                'name' => config('db.basic.guaranty_title'),
                'description' => config('db.basic.guaranty_short_text'),
                'text' => config('db.basic.guaranty_text'),
                'icon' => 'icon-badge-quality',
            ],
        ];
    
        foreach ($services as $position => $serviceDto) {
            $service = new ProductService;
            $service->active = true;
            $service->system = true;
            $service->show_icon = true;
            $service->position = $position;
            $service->icon = array_get($serviceDto, 'icon');
            $service->save();
        
            Language::all()->each(function (Language $language) use ($service, $serviceDto) {
                $translate = new ProductServiceTranslates();
                $translate->name = array_get($serviceDto, 'name') ?: '';
                $translate->description = array_get($serviceDto, 'description');
                $translate->text = array_get($serviceDto, 'text');
                $translate->language = $language->slug;
                $translate->row_id = $service->id;
                $translate->save();
            });
        }
        
        Setting::whereGroup('basic')->whereIn('alias', [
            'delivery_title', 'delivery_short_text', 'delivery_text',
            'payment_title', 'payment_short_text', 'payment_text',
            'guaranty_title', 'guaranty_short_text', 'guaranty_text',
        ])->delete();
    }
    
    private function additionalSpecification()
    {
        $this->call('db:seed', [
            '--class' => ProductDictionarySeeder::class,
            '--force' => true,
        ]);
    }
    
    private function updateDatabaseFeatureValues()
    {
        Product::with('group', 'value')->get()->each(function (Product $product) {
            $exists = ProductGroupFeatureValue::whereValueId($product->value_id)
                ->whereProductId($product->id)
                ->exists();
            if (!$exists && $product->value && $product->value->feature_id) {
                ProductGroupFeatureValue::link($product->group, $product, $product->value->feature_id, $product->value_id);
            }
        });
    }

    private function updateCategories()
    {
        ProductGroup::all()->each(function (ProductGroup $group) {
            $group->syncOtherCategories([], $group->category_id);
        });
    }

    private function updateMailTemplates(): void
    {
        $this->call('db:seed', ['--class' => \App\Modules\Callback\Database\Seeds\MailTemplateSeeder::class]);
        $this->call('db:seed', ['--class' => \App\Modules\Consultations\Database\Seeds\MailTemplateSeeder::class]);
        $this->call('db:seed', ['--class' => \App\Modules\FastOrders\Database\Seeds\MailTemplateChangeSeeder::class]);
        $this->call('db:seed', ['--class' => \App\Modules\Orders\Database\Seeds\MailTemplateAdminSeeder::class]);
        $this->call('db:seed', ['--class' => \App\Modules\Reviews\Database\Seeds\MailTemplateSeeder::class]);
    }

    private function defaultMigration()
    {
        $this->call('migrate');
        $this->call('locotrade:translates');
        $this->call('db:seed', ['--class' => \App\Modules\ProductsAvailability\Database\Seeds\MailTemplateForUserSeeder::class]);
        $this->call('db:seed', ['--class' => \App\Modules\ProductsAvailability\Database\Seeds\MailTemplateSeeder::class]);
        $this->info('Done');
    }

    private $slugs = [];
    private function updateProductModifications()
    {
        Product::all()->each(function (Product $product) {
            
            $parts = [];
            $parts[] = $product->group->name;
            if ($product->value_id) {
                $parts[] = $product->value->current->name;
            }
            
            $name = implode(' ', $parts);
            $slug = '' . $this->generateProductSlug($name);
            
            foreach (config('languages', []) as $languageAlias => $language) {
                $product->dataFor($languageAlias)->update([
                    'name' => '',
                    'slug' => $slug,
                ]);
            }
        });
    }
    
    private function generateProductSlug($value)
    {
        $slug = Str::substr(Str::slug($value), 0, 190);
        $unique = false;
        while (!$unique) {
            $postfix = '';
            if (in_array($slug, $this->slugs)) {
                $slug = Str::substr($slug, 0, 185);
                $postfix = '-' . random_int(10000, 99999);
            }
            if (!in_array($slug.$postfix, $this->slugs)) {
                $slug .= $postfix;
                $unique = true;
            }
        }
        $this->slugs[] = $slug;
        return $slug;
    }
    
}
