<?php

namespace App\Modules\Products\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Modules\Products\Models\Product;
use App\Modules\SeoTemplates\Models\SeoTemplate;
use App\Modules\SeoTemplates\Models\SeoTemplateTranslates;
use Illuminate\Database\Seeder;
use Schema;

class ProductSeoTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('seo_templates')) {
            $seoTemplate = new SeoTemplate();
            $seoTemplate->alias = Product::SEO_TEMPLATE_ALIAS;
            $seoTemplate->variables = [
                'name' => 'products::seo.template-variables.product-name',
                'category' => 'products::seo.template-variables.product-category',
                'categories' => 'products::seo.template-variables.product-categories',
                'price' => 'products::seo.template-variables.product-price',
            ];
            $seoTemplate->save();
        
            Language::all()->each(function (Language $language) use ($seoTemplate) {
                $translate = new SeoTemplateTranslates();
                $translate->name = 'Шаблон для товаров';
                $translate->h1 = '{{name}}';
                $translate->title = '{{name}}';
                $translate->keywords = '{{name}}, {{categories}}';
                $translate->description = '{{name}}';
                $translate->language = $language->slug;
                $translate->row_id = $seoTemplate->id;
                $translate->save();
            });
        }
    }
}
