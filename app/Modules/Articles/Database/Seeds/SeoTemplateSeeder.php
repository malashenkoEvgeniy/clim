<?php

namespace App\Modules\Articles\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Modules\Articles\Models\Article;
use App\Modules\SeoTemplates\Models\SeoTemplate;
use App\Modules\SeoTemplates\Models\SeoTemplateTranslates;
use Illuminate\Database\Seeder;
use Schema;

class SeoTemplateSeeder extends Seeder
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
            $seoTemplate->alias = Article::SEO_TEMPLATE_ALIAS;
            $seoTemplate->variables = [
                'name' => 'articles::seo.template-variables.name',
            ];
            $seoTemplate->save();
    
            Language::all()->each(function (Language $language) use ($seoTemplate) {
                $translate = new SeoTemplateTranslates();
                $translate->name = 'Шаблон для статей';
                $translate->h1 = '{{name}}';
                $translate->title = '{{name}}';
                $translate->keywords = '{{name}}';
                $translate->description = '{{name}}';
                $translate->language = $language->slug;
                $translate->row_id = $seoTemplate->id;
                $translate->save();
            });
        }
    }
}
