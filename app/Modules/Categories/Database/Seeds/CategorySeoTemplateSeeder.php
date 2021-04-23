<?php

namespace App\Modules\Categories\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Modules\Categories\Models\Category;
use App\Modules\SeoTemplates\Models\SeoTemplate;
use App\Modules\SeoTemplates\Models\SeoTemplateTranslates;
use Illuminate\Database\Seeder;
use Schema;

class CategorySeoTemplateSeeder extends Seeder
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
            $seoTemplate->alias = Category::SEO_TEMPLATE_ALIAS;
            $seoTemplate->variables = [
                'name' => 'categories::seo.template-variables.category-name',
                'content' => 'categories::seo.template-variables.category-content',
            ];
            $seoTemplate->save();
        
            Language::all()->each(function (Language $language) use ($seoTemplate) {
                $translate = new SeoTemplateTranslates();
                $translate->name = 'Шаблон для категорий товаров';
                $translate->h1 = '{{name}}';
                $translate->title = '{{name}}';
                $translate->keywords = '{{name}}';
                $translate->description = '{{content:20}}';
                $translate->language = $language->slug;
                $translate->row_id = $seoTemplate->id;
                $translate->save();
            });
        }
    }
}
